<?php
// FROM HASH: b1003a5d46ad3c419f763899a6c32381
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('user_upgrad_card.less');
	$__finalCompiled .= '
<div class="creditsPricingCards" id="recurringCreditsCards">
	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box1-top">
			<p><b>Premium Companion Subscription</b></p>
			<h2>$80</h2>
			<p>/monthly</p>
		</div>
		<div class="card_descriptions" style="">

			<div class="user-upgrades__block box1-upgrades__block">
				<ul>
					<li>Post up to 2 times daily.</li>
					<li>Great for those who plan to use the site multiple times.</li>
				</ul>
			</div>
		</div>
		<br/>
		<br/>
		<br/>
		<a href="" class="blockoPayBtn button box1-btn" data-toggle="modal" data-uid=07f50d8e6a44405c>
			Upgrade 
			<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
		</a>
	</div>

	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box2-top">
			<p><b>Top 10 Provider City Highlight</b></p>
			<h2>$100</h2>
			<p>/monthly</p>
		</div>
		<div class="card_descriptions" style="">

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
		<br/>
		<a href="" class="blockoPayBtn button box2-btn" data-toggle="modal" data-uid=08785fe7b68d4191>
			Upgrade 
			<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
		</a>
	</div>

	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box3-top">
			<p><b>VIP Companion Subscription</b></p>
			<h2>$120</h2>
			<p>/monthly</p>
		</div>
		<div class="card_descriptions" style="">

			<div class="user-upgrades__block  box3-upgrades__block">
				<ul>
					<li>Option to repost.</li>
					<li>Post up to 4 times daily.</li>
					<li>Enhanced photo storage capacity.</li>
					<li>Ideal for highly active board members.</li>
					<li>1-month subscription with each purchase.</li>
				</ul>
			</div>
		</div>
		<a href="" class="blockoPayBtn button box3-btn" data-toggle="modal" data-uid=bdc79d69a8644148>
			Upgrade 
			<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
		</a>
	</div>

	<div class="creditsPricingCard">
		<div class="creditsPricingCardTop box4-top">
			<p><b>Top 20 Provider VIP Highlight</b></p>
			<h2>$200</h2>
			<p>/monthly</p>
		</div>
		<div class="card_descriptions" style="">

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
		<br/>
		<a href="" class="blockoPayBtn button box4-btn" data-toggle="modal" data-uid=c55436c607ba44f1>
			Upgrade 
			<img class="paymnet_btc_img" src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
		</a>
	</div>
</div>';
	return $__finalCompiled;
}
);