<?php
// FROM HASH: 326e20a97afb21170e0431bf08616a0a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<xen:if is="' . $__templater->escape($__vars['canGift']) . '">
	<li><a href="{xen:link members/gift, $user}" class="OverlayTrigger">{xen:phrase nf_giftupgrades_gift}</a></li>
</xen:if>';
	return $__finalCompiled;
}
);