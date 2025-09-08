<?php

namespace XenGenTr\XGTForumistatistik\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ForumIstatistik extends Repository
{
    public function findForumIstatistikleriForList($activeOnly = false)
    {
        $finder = $this->finder('XenGenTr\XGTForumistatistik:ForumIstatistik')
            ->with('ForumIstatistikIcerik', true)
            ->order('active', 'DESC')
            ->order('display_order', 'ASC');

        if ($activeOnly)
        {
            $finder->where('active', 1);
        }

        return $finder;
    }

    public function getForumIstatistikleriForDisplay()
    {
        $simpleCache = $this->app()->simpleCache();

        $forumIstatistikIcerikCache = $simpleCache['XenGenTr/XGTForumistatistik']['forumIstatistikIcerik'];

        if ($forumIstatistikIcerikCache === null)
        {
            $forumIstatistikIcerikCache = $this->rebuildForumIstatistikIcerikCache();
        }

        $forumIstatistikCache = $simpleCache['XenGenTr/XGTForumistatistik']['forumIstatistik'];

        if ($forumIstatistikCache === null)
        {
            $forumIstatistikCache = $this->rebuildForumIstatistikCache();
        }

        $pozisyonlar = $baslangic = [];

        foreach ($forumIstatistikCache as $pozinyon => $forumIstatistikleriInPozinyon)
        {
            foreach ($forumIstatistikleriInPozinyon as $forumIstatistik)
            {
                $relations = [];
                if (isset($forumIstatistikIcerikCache[$forumIstatistik['icerik_id']]))
                {
                    $relations['ForumIstatistikIcerik'] = $this->em->instantiateEntity('XenGenTr\XGTForumistatistik:ForumIstatistikIcerik', $forumIstatistikIcerikCache[$forumIstatistik['icerik_id']]);
                }
                $pozisyonlar[$pozinyon][$forumIstatistik['veri_id']] = $this->em->instantiateEntity('XenGenTr\XGTForumistatistik:ForumIstatistik', ['veri_id' => $forumIstatistik['veri_id']], $relations);
                $pozisyonlar[$pozinyon][$forumIstatistik['veri_id']]->bulkSet($forumIstatistik, ['skipInvalid' => true]);
            }
        }

        foreach ($pozisyonlar as $pozinyon => $forumIstatistikleriInPozinyon)
        {
            $baslangic[$pozinyon] = reset($forumIstatistikleriInPozinyon);
        }

        $sonuclar = [
            'pozisyonlar' => $pozisyonlar,
            'baslangic'     => $baslangic,
        ];

        return $sonuclar;
    }

    public function renderForumIstatistikleri($context = '')
    {
        $options = $this->options();

        if (!\XF::visitor()->canIstatistikleriGor() || ($context && $context != $options->xgtForumistatik_konumu))
        {
            return '';
        }

        $templateName = 'public:xgt_FrmIstatistik';

        $params = [
            'forumIstatistikleri' => $this->getForumIstatistikleriForDisplay(),
        ];

        return $this->app()->templater()->renderTemplate(
            $templateName, $params
        );
    }

    public function getForumIstatistikCache()
    {
        $forumIstatistikleri = $this->findForumIstatistikleriForList(true)->fetch();

        $pozisyonlar = [];

        foreach ($forumIstatistikleri as $forumIstatistik)
        {
            $pozisyonlar[$forumIstatistik->pozinyon][$forumIstatistik->veri_id] = [
                'veri_id'       => $forumIstatistik->veri_id,
                'icerik_id'     => $forumIstatistik->icerik_id,
                'pozinyon'      => $forumIstatistik->pozinyon,
                'display_order' => $forumIstatistik->display_order,
                'options'       => $forumIstatistik->options,
                'active'        => $forumIstatistik->active,
                'custom_title'  => $forumIstatistik->custom_title,
				'veri_ikonu'    => $forumIstatistik->veri_ikonu,
            ];
        }

        return $pozisyonlar;
    }

    public function rebuildForumIstatistikCache()
    {
        $cache = $this->getForumIstatistikCache();

        $simpleCache = $this->app()->simpleCache();
        $simpleCache['XenGenTr/XGTForumistatistik']['forumIstatistik'] = $cache;

        return $cache;
    }

    public function getForumIstatistikIcerikCache()
    {
        $output = [];

        $forumIstatistikIcerikler = $this->finder('XenGenTr\XGTForumistatistik:ForumIstatistikIcerik')
            ->order('icerik_id');

        foreach ($forumIstatistikIcerikler->fetch() AS $forumIstatistik)
        {
            $output[$forumIstatistik->icerik_id] = [
                'icerik_id'     => $forumIstatistik->icerik_id,
                'icerik_sinifi' => $forumIstatistik->icerik_sinifi,
            ];
        }

        return $output;
    }

    public function rebuildForumIstatistikIcerikCache()
    {
        $cache = $this->getForumIstatistikIcerikCache();

        $simpleCache = $this->app()->simpleCache();

        $simpleCache['XenGenTr/XGTForumistatistik']['forumIstatistikIcerik'] = $cache;

        \XF::runOnce('xengentrForumIstatistikCacheRebuild', function()
        {
            $this->rebuildForumIstatistikCache();
        });

        return $cache;
    }
}