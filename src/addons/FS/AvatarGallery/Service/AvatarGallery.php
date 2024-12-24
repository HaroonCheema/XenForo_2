<?php

namespace FS\AvatarGallery\Service;

class AvatarGallery extends \XF\Service\AbstractService
{
    public function getRandomAvatar()
    {
        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        $randomKey = array_rand($files);

        if ($files[$randomKey]['extension'] == "html") {
            $randomKey = array_rand($files);
        }

        return $files[$randomKey]['path'];
    }

    public function getRandomAvatars()
    {
        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        if (!count($files)) {

            return;
        }

        $randomKey = array_rand($files);

        if ($files[$randomKey]['extension'] == "html") {
            $randomKey = array_rand($files);
        }

        $randomImgPath = $files[$randomKey]['path'];

        $randomImage = [
            'url' => \XF::app()->applyExternalDataUrl($randomImgPath),
            'data-path' => $randomImgPath
        ];

        return $randomImage;
    }

    public function getGalleryImagesRegister()
    {
        $valid_extensions = [
            'jpg',
            'jpeg',
            'gif',
            'png'
        ];

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        $formatted = [];

        foreach ($files as $file) {
            $category = preg_replace('/gallery_avatars\/?/', '', $file['dirname']);

            if (empty($category)) {
                $category = \XF::phrase('fs_uncategorized')->render();
            }

            if ($file['type'] === 'file' && in_array(strtolower($file['extension']), $valid_extensions)) {
                $formatted[$category][] = [
                    'url' => \XF::app()->applyExternalDataUrl($file['path']),
                    'data-path' => $file['path']
                ];
            }
        }

        ksort($formatted);

        return $formatted;
    }

    public function getGalleryImagesAccount()
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
        foreach ($files as $file) {
            $category = preg_replace('/gallery_avatars\/?/', '', $file['dirname']);

            if (empty($category)) {
                $category = \XF::phrase('fs_uncategorized')->render();
            }
            if ($file['type'] === 'file' && in_array(strtolower($file['extension']), $valid_extensions)) {
                $permission = '';
                if ($permission == null) {
                    $formatted[$category]['permission'] = '2';
                } else {
                    $formatted[$category]['permission'] = false;
                    if (in_array($userGroup, $permission['permission_category'])) {
                        $formatted[$category]['permission'] = true;
                    }
                    foreach ($secondaryUserGroup as $Goup) {
                        if (in_array($Goup, $permission['permission_category'])) {
                            $formatted[$category]['permission'] = true;
                        }
                    }
                }
                $formatted[$category]['dirname'][] = [
                    'url' => \XF::app()->applyExternalDataUrl($file['path']),
                    'data-path' => $file['path']
                ];
            }
        }
        ksort($formatted);
        return $formatted;
    }
}
