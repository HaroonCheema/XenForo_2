<?php


namespace FS\SwbFemaleVerify\Alert;


use XF\Alert\AbstractHandler;

class Female extends AbstractHandler
{
	public function getOptOutActions()
	{
		return [
			'reject',
			'complete'
		];
	}
}
