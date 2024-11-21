<?php

namespace XenBulletin\AvatarGallery\XF\Pub\Controller;

class Account extends XFCP_Account
{
    public function actionAvatar()
    {
        if ($this->isPost()) {
            if ($this->filter('delete_avatar', 'bool') && !\XF::visitor()->hasPermission('general', 'xb_can_delete_avatar'))
            {
                return $this->error('xb_you_can_t_delete_your_avatar');
            }
        }
        $reply = parent::actionAvatar();

        if(!$this->options()->xb_enable)
        {
            return $reply;
        }

        if ($this->isPost()) {
            if($gallery_avatar = $this->filter('gallery_avatar', 'str'))
            {
                if(\XF::app()->fs()->has('data://' . $gallery_avatar))
                {
                    $tmp = tempnam($this->options()->xb_change_the_path_to_the_tmp_file, 'php');
                    $data = \XF::app()->fs()->readStream('data://' . $gallery_avatar);

                    file_put_contents($tmp, $data);

                    $visitor = \XF::visitor();

                    $avatarService = $this->service('XF:User\Avatar', $visitor);

                    $avatarService->setImage($tmp);
                    $avatarService->updateAvatar();

                    unlink($tmp);
                }
            }
        }
        else
        {
            $reply->setParam('gallery_images', $this->getGalleryImages());
        }

        return $reply;
    }

    private function getGalleryImages()
    {
        $valid_extensions = [
            'jpg',
            'jpeg',
            'gif',
            'png'
        ];

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);
        

        $formatted = [];
        $visitor = \XF::visitor();
        $userGroup = $visitor->user_group_id;
        $secondaryUserGroup = $visitor->secondary_group_ids;
        foreach($files as $file) {
            $category = preg_replace('/gallery_avatars\/?/', '', $file['dirname']);

            if(empty($category))
            {
                $category = \XF::phrase('xb_uncategorized')->render();
            }
            if($file['type'] === 'file' && in_array(strtolower($file['extension']), $valid_extensions))
            {
                $permission = '';
                if($permission == null){
                    $formatted[$category]['permission'] = '2';
                }
                else{
                    $formatted[$category]['permission'] = false;
                    if(in_array($userGroup, $permission['permission_category'])){
                        $formatted[$category]['permission'] = true;
                    }
                    foreach ($secondaryUserGroup as $Goup){
                        if(in_array($Goup, $permission['permission_category'])){
                            $formatted[$category]['permission'] = true;
                        }
                    }
                }
                $formatted[$category]['dirname'][] =
                [
                    'url' => $this->app()->applyExternalDataUrl($file['path']),
                    'data-path' => $file['path']
                ];
            }
        }
        ksort($formatted);
        return $formatted;
    }
}