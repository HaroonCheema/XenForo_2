<?php

namespace TS\MGC\XFMG\Entity;

class Comment extends XFCP_Comment {
	
	protected function _postSave()
	{
		parent::_postSave();
		$visibilityChange = $this->isStateChanged('comment_state', 'visible');

		if ($this->isUpdate())
		{
			if ($visibilityChange == 'enter')
			{
				$this->User->changeCommentCounter(1);
			}
			else if ($visibilityChange == 'leave')
			{
				$this->User->changeCommentCounter(-1);

			}
		}
		else
		{
			// insert
			if ($this->comment_state == 'visible')
			{
				$this->User->changeCommentCounter(1);
			}
		}

	}	
	
	protected function _postDelete()
	{
		parent::_postDelete();
		$this->User->changeCommentCounter(-1);
		
	}
	
}