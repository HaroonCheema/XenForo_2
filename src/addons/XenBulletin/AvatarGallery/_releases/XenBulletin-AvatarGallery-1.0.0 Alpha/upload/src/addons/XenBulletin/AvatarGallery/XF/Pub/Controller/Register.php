<?php

namespace XenBulletin\AvatarGallery\XF\Pub\Controller;

class Register extends XFCP_Register
{
	public function actionIndex()
    {
        if(\XF::visitor()->user_id)
        {
            return $this->redirect($this->getDynamicRedirectIfNot($this->buildLink('register')), '');
        }

        $parent = parent::actionIndex();
        if($parent instanceof \XF\Mvc\Reply\View)
        {
            $option = \xf::options();
            if($option->xb_enable)
            {
                $parent->setParam('gallery_images', $this->getGalleryImages());
                return $parent;
            }

            $parent->setParam('gallery_images', false);
        }

        return $parent;
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
	
			foreach($files as $file)
			{
				$category = preg_replace('/gallery_avatars\/?/', '', $file['dirname']);
	
				if(empty($category))
				{
					$category = \XF::phrase('xb_uncategorized')->render();
				}
	
				if($file['type'] === 'file' && in_array(strtolower($file['extension']), $valid_extensions))
				{
					$formatted[$category][] =
					[
						'url' => $this->app()->applyExternalDataUrl($file['path']),
						'data-path' => $file['path']
					];
				}
			}
	
			ksort($formatted);
	
			return $formatted;
	}

	public function actionRegister()
	{
		$option = \xf::options();
		$avatarInput = $this->request->filter('gallery_avatar', 'str');
		if(!$avatarInput &&
		$option->xb_enable)
		{
			return $this->error(\XF::phrase('xb_required_error'));
		}

		return parent::actionRegister();
	}

	protected function finalizeRegistration(\XF\Entity\User $user)
    {
		parent::finalizeRegistration($user);
		$option = \xf::options();
		if($option->xb_enable)
		{
            $gallery_avatar = $this->filter('gallery_avatar', 'str');
			if(\XF::app()->fs()->has('data://' . $gallery_avatar))
			{
				$tmp = tempnam($option->xb_change_the_path_to_the_tmp_file, 'php');
				$data = \XF::app()->fs()->readStream('data://' . $gallery_avatar);

				file_put_contents($tmp, $data);

				$avatarService = $this->service('XF:User\Avatar', $user);

				$avatarService->setImage($tmp);
				$avatarService->updateAvatar();

				unlink($tmp);
			}
		}
    }
}