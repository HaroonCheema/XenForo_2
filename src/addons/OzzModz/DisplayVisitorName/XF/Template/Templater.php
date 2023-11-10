<?php

namespace OzzModz\DisplayVisitorName\XF\Template;

class Templater extends XFCP_Templater
{
	public function fnBbCode($templater, &$escape, $bbCode, $context, $content, array $options = [], $type = 'html')
	{
		/** @var \OzzModz\DisplayVisitorName\Helper\Replacer $replacer */
		$replacer = \XF::helper('OzzModz\DisplayVisitorName:Replacer');
		$bbCode = $replacer->replaceVisitorName($bbCode, 'message');

		return parent::fnBbCode($templater, $escape, $bbCode, $context, $content, $options, $type);
	}

	public function fnSnippet($templater, &$escape, $string, $maxLength = 0, array $options = [])
	{
		/** @var \OzzModz\DisplayVisitorName\Helper\Replacer $replacer */
		$replacer = \XF::helper('OzzModz\DisplayVisitorName:Replacer');
		$string = $replacer->replaceVisitorName($string, 'message');

		return parent::fnSnippet($templater, $escape, $string, $maxLength, $options); // TODO: Change the autogenerated stub
	}
}
