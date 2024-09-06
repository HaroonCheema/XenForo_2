<?php

namespace FS\SwbFemaleVerify\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use FS\SwbFemaleVerify\Addon;


class FemaleVerification extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_swb_female_verify';
        $structure->shortName = 'FS\SwbFemaleVerify:FemaleVerification';
        $structure->contentType = 'fs_swb_female_verify';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],

            'user_id' => ['type' => self::UINT, 'required' => true],

            'female_state' => [
                'type' => self::STR,
                'allowedValues' => [
                    'pending',
                    'rejected',
                    'sent'
                ],
                'default' => 'pending',
                'api' => true
            ],
            'reject_reason' => ['type' => self::STR, 'default' => '', 'maxLength' => 255, 'api' => true],
            'create_date' => ['type' => self::UINT, 'default' => \XF::$time, 'api' => true],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
        ];
        $structure->defaultWith = [];
        $structure->getters = [
            'state_phrase' => ['getter' => true, 'cache' => false],
        ];
        $structure->behaviors = [];

        return $structure;
    }

    public function getImgUrl($canonical = true, $type)
    {
        $verifyId = $this->id;
        $path = sprintf('SwbFemaleVerification/'  . $type . '/%d/%d.jpg', floor($verifyId / 1000), $verifyId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }

    public function getAbstractedCustomImgPath($type)
    {
        $verifyId = $this->id;

        return sprintf('data://SwbFemaleVerification/' . $type . '/%d/%d.jpg', floor($verifyId / 1000), $verifyId);
    }

    public function isImage($type)
    {
        $fs = $this->app()->fs();

        $ImgPath = $this->getAbstractedCustomImgPath($type);

        if ($fs->has($ImgPath)) {
            return 'true';
        }
    }

    protected function _postSave()
    {
        if ($this->isChanged('female_state')) {
            $this->rebuildPendingCounts();
        }
    }

    protected function rebuildPendingCounts()
    {
        \XF::runOnce('pendingFemalesCountsRebuild', function () {
            $this->getQueueRepo()->rebuildPendingCounts();
        });
    }

    /**
     * @return Repository|\FS\SwbFemaleVerify\Repository\FemaleVerify
     */
    protected function getQueueRepo()
    {
        return $this->repository(Addon::shortName('FemaleVerify'));
    }
}
