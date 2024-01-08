<?php
// FROM HASH: b585d5fd9a0955bc3bc78ec592176c62
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account upgrades');
	$__finalCompiled .= '

<style>

	.upgrade-blocks {
		list-style: none;
		margin: 24px 0;
		padding: 0 0 24px 0;

		@media all and (min-width: 1201px) {
			display: flex;
			align-items: flex-start;
			flex-wrap: wrap;
			margin-left: 40px;
			margin-right: 40px;
		}

		.upgrade-block {
			position: relative;

			@media all and (min-width: 1201px) {
				margin: 1%;
				width: 31%;
			}

			@media all and (max-width: 1200px) {
				padding: 10px;
				width: 330px !important;
			}

			form {
				background: #fff;
			}
		}

		.upgrade-block--regular {
			.upgrade-header {
				background: #49adfd url("' . $__templater->func('base_url', array('styles/glitch/xenforo/backgrounds/regular.png', ), true) . '") no-repeat center center / cover;
			}
			ul li:before {
				color: #49adfd;
			}
		}

		.premium-icon {
			position: absolute;
			width: 50px;
			right: 28px;
			top: 49px;
		}

		.upgrade-block--premium {
			.upgrade-header {
				background: #ffb306 url("' . $__templater->func('base_url', array('styles/glitch/xenforo/backgrounds/premium.png', ), true) . '") no-repeat center center / cover;
			}
			ul li:before {
				color: #ffb306;
			}
			button {
				background: #ffb306;
				border-color: #ffb306;
				margin: 0 auto;

				&:hover {
					background: xf-intensify(#ffb306, 5%);
					border-color: xf-intensify(#ffb306, 5%);
				}
			}
		}

		.upgrade-header {
			padding: 40px 28px;

			.upgrade-header__title {
				color: #fff;
				font-size: 16px;
				font-weight: bold;
			}

			.upgrade-header__price {
				color: #fff;
				font-size: 32px;

				small {
					font-size: 15px;
				}
			}
		}

		.user-upgrade-x {
			background: #f1f1f2;
			border-radius: 50%;
			color: #000;
			font-size: 20px;
			font-weight: 600;
			height: 50px;
			line-height: 49px;
			right: 28px;
			position: absolute;
			text-align: center;
			top: 49px;
			width: 50px;
		}

		.user-upgrade-text {
			border-bottom: 1px solid #f1f1f2;
			color: #586969;
			padding: 16px 28px;
		}

		.user-upgrades__block {
			border-bottom: 1px solid #f1f1f2;
			padding: 16px 28px;

			label {
				color: #b3b3b3;
				display: block;
				font-size: 14px;
				margin-bottom: 10px;
			}

			ul {
				list-style: none;
				margin: 0;
				padding: 0;

				li {
					color: #01050e;
					font-size: 15px;
					margin: 7px 0;
					padding-left: 24px;
					position: relative;

					&:before {
						content: "\\f058";
						font-family: "Font Awesome 5 Pro";
						font-size: 16px;
						left: 0;
						position: absolute;
					}
				}
			}
		}

		.upgrade-description {

		}

		.upgrade-payment {
			padding: 16px 28px;

			button {
				border-radius: 40px;
				display: flex;
				height: 48px;
				margin: 0 auto;
				max-width: 250px;
				width: 100%;
			}
		}
	}

	.blockMessage {
		.shareButtons {
			padding: 25px;
		}
	}

</style>

';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '

		<ul class="upgrade-blocks">


			<li class="upgrade-block upgrade-block--premium">
				' . '
				';
	$__compilerTemp2 = '';
	if ($__vars['upgrade']['user_upgrade_id'] == 1) {
		$__compilerTemp2 .= '<img class="premium-icon" src="' . $__templater->func('base_url', array('styles/glitch/xenforo/premium-icon.png', ), true) . '" alt="" />';
	}
	$__compilerTemp1 .= $__templater->form('
					<div class="upgrade-header">
						<div class="upgrade-header__title">title</div>
						<div class="upgrade-header__price">
							<strong>$20</strong>

							<small>' . 'Month' . '</small>

						</div>
						' . $__compilerTemp2 . '
					</div>

					<div class="upgrade-description">
						<div class="user-upgrade-text">Upgrade Only! £8.99, €9.99, $10.99</div>

						<div class="user-upgrades__block">
							<label>Monthly Access to:</label>
							<ul>
								<li><strong>1000\'s</strong> of Archived Challenges</li>
								<li><strong>3x</strong> Leaderboard Point Boost</li>
								<li><strong>3x</strong> Premium Challenge Credits</li>
							</ul>
						</div>
					</div>

					<div class="upgrade-payment">

						' . $__templater->button('Purchase', array(
		'type' => 'submit',
	), '', array(
	)) . '

						' . $__templater->formHiddenVal('payment_profile_id', '"ok"', array(
	)) . '
					</div>
				', array(
		'action' => $__templater->func('link', array('purchase', ), false),
		'ajax' => 'true',
		'data-xf-init' => 'payment-provider-container',
	)) . '
			</li>
		</ul>

	';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	' . $__compilerTemp1 . '
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are currently no purchasable user upgrades.' . '</div>
';
	}
	return $__finalCompiled;
}
);