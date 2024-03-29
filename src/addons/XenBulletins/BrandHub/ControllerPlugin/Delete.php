<?php

namespace XenBulletins\BrandHub\ControllerPlugin;

use XF\Mvc\Entity\Entity;
use XF\ControllerPlugin\AbstractPlugin;

class Delete extends AbstractPlugin
{
	public function actionDelete(Entity $entity, $confirmUrl, $contentUrl, $returnUrl, $contentTitle, $template = null, array $params = [])
	{
		if (!$entity->preDelete())
		{
			return $this->error($entity->getErrors());
		}

		if ($this->isPost())
		{       
                    $item = $entity->Item;
                
			$entity->delete();
//			return $this->redirect($returnUrl);
                        
                        $reply = $this->view('XenBulletins\BrandHub:Item\ItemPage', 'bh_list_ownerPage', ['item' => $item]);
                        $reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
                        return $reply;
		}
		else
		{
			$viewParams = [
				'content' => $entity,
				'confirmUrl' => $confirmUrl,
				'contentUrl' => $contentUrl,
				'contentTitle' => $contentTitle
			] + $params;
			return $this->view('XF:Delete\Delete', $template ?: 'public:delete_confirm', $viewParams);
		}
	}
}