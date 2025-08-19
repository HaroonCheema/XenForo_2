<?php
// FROM HASH: 19298667dd598d38bee0bc53663334ec
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Create ad');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Select ad type');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'code', ), ), true) . '">' . 'Code' . '</a>
				</h3>
				' . 'Use this ad type if you want to display ads such as AdSense, affiliate banners, etc.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'banner', ), ), true) . '">' . 'Banner' . '</a>
				</h3>
				' . 'Use this ad type if you want to display image banner ads uploaded from your device or from image hosting services.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'text', ), ), true) . '">' . 'Text' . '</a>
				</h3>
				' . 'Use this ad type if you want to display text ads with a title as the link and a short description below, and optionally a small image.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'link', ), ), true) . '">' . 'Link' . '</a>
				</h3>
				' . 'Use this ad type if you want to display link ads in sidebar as lists of links or inline anywhere else.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'keyword', ), ), true) . '">' . 'Keyword' . '</a>
				</h3>
				' . 'Use this ad type if you want to transform keywords into ad links in thread posts, conversation messages and profile posts.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'affiliate', ), ), true) . '">' . 'Affiliate link' . '</a>
				</h3>
				' . 'Use this ad type if you want to transform links into affiliate links in thread posts, conversation messages and profile posts.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'thread', ), ), true) . '">' . 'Promo thread' . '</a>
				</h3>
				' . 'Use this ad type if you want to create a promo thread.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'sticky', ), ), true) . '">' . 'Sticky thread' . '</a>
				</h3>
				' . 'Use this ad type if you want to make a thread sticky.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'resource', ), ), true) . '">' . 'Featured resource' . '</a>
				</h3>
				' . 'Use this ad type if you want to make a resource featured in XenForo Resource Manager.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'popup', ), ), true) . '">' . 'Popup' . '</a>
				</h3>
				' . 'Use this ad type if you want to display ads in a popup. ' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'background', ), ), true) . '">' . 'Background' . '</a>
				</h3>
				' . 'Use this ad type if you want to display background ads.' . '
			</div>
			<div class="block-row block-row--separated">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('ads-manager/ads/add/', null, array('type' => 'custom', ), ), true) . '">' . 'Custom service' . '</a>
				</h3>
				' . 'Use this ad type if you want to keep track of custom service ads.' . '
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);