<?php
// FROM HASH: 1421acd9bb2f9cc001cd9b08c4ac5f6f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Create package');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Use a package if you want to manage and/or rotate multiple ads of the same type or if you want to make money by selling ad spaces.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

<div class="blockMessage blockMessage--important blockMessage--iconic">
	' . ' When using a package, set your settings and criteria in the package and assign the package for each ad when creating ads from admin control panel. Doing so, you won\'t have to set the settings and criteria for each ad individually because it will automatically inherit the package\'s settings and criteria.' . '
</div>

<div class="block">
	<div class="block-container">
		<div class="block-body">
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'code', ), ), true) . '">' . 'Code' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own code ads such as AdSense, affiliate banners, etc. It is not recommended to sell this ad type.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'banner', ), ), true) . '">' . 'Banner' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own banner ads or if you want to sell banner ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'text', ), ), true) . '">' . 'Text' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own text ads or if you want to sell text ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'link', ), ), true) . '">' . 'Link' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own link ads or if you want to sell link ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'keyword', ), ), true) . '">' . 'Keyword' . '</a>
				</h3>
				' . 'Use this package if you want to sell keyword ads in thread posts, conversation messages and profile posts.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'affiliate', ), ), true) . '">' . 'Affiliate link' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own affiliate link ads. Cannot be used to sell this type of ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'thread', ), ), true) . '">' . 'Promo thread' . '</a>
				</h3>
				' . 'Use this package if you want to sell promo threads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'sticky', ), ), true) . '">' . 'Sticky thread' . '</a>
				</h3>
				' . 'Use this package if you want to sell sticky threads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'resource', ), ), true) . '">' . 'Featured resource' . '</a>
				</h3>
				' . 'Use this package if you want to sell featured resources in XenForo Resource Manager.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'popup', ), ), true) . '">' . 'Popup' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own popup ads or if you want to sell popup ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'background', ), ), true) . '">' . 'Background' . '</a>
				</h3>
				' . 'Use this package if you want to manage your own background ads or if you want to sell background ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/packages/add/', '', array('type' => 'custom', ), ), true) . '">' . 'Custom service' . '</a>
				</h3>
				' . 'Use this package if you want to manage custom service ads.' . '
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);