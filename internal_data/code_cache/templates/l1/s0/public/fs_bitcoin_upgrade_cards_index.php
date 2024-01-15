<?php
// FROM HASH: b5296c4ef402f7711cee4ed58bd18507
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account Upgrade');
	$__finalCompiled .= '

';
	$__templater->includeCss('user_upgrad_card.less');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => ('bionomics/upgrade.js?' . $__vars['xf']['time']),
	));
	$__finalCompiled .= '
<div class="creditsPricingCards" id="recurringCreditsCards">
	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box1-top">
			' . '<p>' . $__templater->escape($__vars['premiumUpgrade']['title']) . '</p>
<h2>' . $__templater->escape($__vars['premiumUpgrade']['cost_amount']) . '</h2>
<p>/ ' . $__templater->escape($__vars['premiumUpgrade']['length_unit']) . '</p>' . '
		</div>
		' . '<div class="card_descriptions" style="">
	<div class="user-upgrades__block box1-upgrades__block">
		<ul>
			<li>Post up to 2 times daily.</li>
			<li>Great for those who plan to use the site multiple times.</li>
		</ul>
	</div>
</div>
<br/>
<br/>
<br/><br/><br/>' . '
		
		';
	if ($__vars['premiumUpgrade'] AND (!$__templater->method($__vars['premiumUpgrade'], 'getUserUpgradeExit', array()))) {
		$__finalCompiled .= '
			<a href=""  data-validation-url="' . $__templater->func('link', array('account-upgrade/purchase', ), true) . '" data-xf-click="show-upgrade-box" data-option-value="fs_bitcoin_premium_companion" class=" button box1-btn"  >
				' . 'Upgrade' . '
				<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
			</a>
		';
	} else {
		$__finalCompiled .= '
			' . 'Activated' . '
		';
	}
	$__finalCompiled .= '
			
	</div>

	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box2-top">
				' . '<p>' . $__templater->escape($__vars['providerCityUpgrade']['title']) . '</p>
<h2>' . $__templater->escape($__vars['providerCityUpgrade']['cost_amount']) . '</h2>
<p>/ ' . $__templater->escape($__vars['providerCityUpgrade']['length_unit']) . '</p>' . '
		
	
		</div>
		' . '<div class="card_descriptions" style="">
	<div class="user-upgrades__block  box2-upgrades__block">
		<ul>
			<li>Limited to 10 spots.</li>
			<li>30-day highlighted period.</li>
			<li>Featured at the top of each city listing.</li>
		</ul>
	</div>
</div>
<br/>
<br/>
<br/>
<br/><br/>' . '
		';
	if ($__vars['providerCityUpgrade'] AND (!$__templater->method($__vars['providerCityUpgrade'], 'getUserUpgradeExit', array()))) {
		$__finalCompiled .= '
			<a href=""  data-validation-url="' . $__templater->func('link', array('account-upgrade/purchase', ), true) . '" data-xf-click="show-upgrade-box" data-option-value="fs_bitcoin_provider_city" class=" button box2-btn"  >
				' . 'Upgrade' . ' 
				<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
			</a>
		';
	} else {
		$__finalCompiled .= '
			' . 'Activated' . '
		';
	}
	$__finalCompiled .= '
	</div>

	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box3-top">
				' . '<p>' . $__templater->escape($__vars['vipUpgrade']['title']) . '</p>
<h2>' . $__templater->escape($__vars['vipUpgrade']['cost_amount']) . '</h2>
<p>/ ' . $__templater->escape($__vars['vipUpgrade']['length_unit']) . '</p>' . '
		
		</div>
		' . '<div class="card_descriptions" style="">
	<div class="user-upgrades__block  box3-upgrades__block">
		<ul>
			<li>Option to repost.</li>
			<li>Post up to 4 times daily.</li>
			<li>Enhanced photo storage capacity.</li>
			<li>Ideal for highly active board members.</li>
			<li>1-month subscription with each purchase.</li>
		</ul>
	</div>
</div>' . '
	    ';
	if ($__vars['vipUpgrade'] AND (!$__templater->method($__vars['vipUpgrade'], 'getUserUpgradeExit', array()))) {
		$__finalCompiled .= '
			<a href=""  data-validation-url="' . $__templater->func('link', array('account-upgrade/purchase', ), true) . '" data-xf-click="show-upgrade-box" data-option-value="fs_bitcoin_vip_companion" class=" button box3-btn"  >
			' . 'Upgrade' . ' 
			<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '"></a>
		';
	} else {
		$__finalCompiled .= '
			' . 'Activated' . '
		';
	}
	$__finalCompiled .= '
		
	</div>

	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box4-top">
			' . '<p>' . $__templater->escape($__vars['providerVipUpgrade']['title']) . '</p>
<h2>' . $__templater->escape($__vars['providerVipUpgrade']['cost_amount']) . '</h2>
<p>/ ' . $__templater->escape($__vars['providerVipUpgrade']['length_unit']) . '</p>' . '
		
			
		</div>
		' . '<div class="card_descriptions" style="">
	<div class="user-upgrades__block  box4-upgrades__block">
		<ul>
			<li>Limited to 20 spots.</li>
			<li>30-day highlight period.</li>
			<li>Featured at the top of the board.</li>
		</ul>
	</div>
</div>
<br/>
<br/>
<br/>
<br/><br/>' . ' 
		';
	if ($__vars['providerVipUpgrade'] AND (!$__templater->method($__vars['providerVipUpgrade'], 'getUserUpgradeExit', array()))) {
		$__finalCompiled .= '
			<a href=""  data-validation-url="' . $__templater->func('link', array('account-upgrade/purchase', ), true) . '" data-xf-click="show-upgrade-box" data-option-value="fs_bitcoin_provider_vip" class=" button box4-btn"  >
					' . 'Upgrade' . ' 
				<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
			</a>
		';
	} else {
		$__finalCompiled .= '
			' . 'Activated' . '
		';
	}
	$__finalCompiled .= '
	</div>
</div>
<div id="purchase_bitcoin"></div>';
	return $__finalCompiled;
}
);