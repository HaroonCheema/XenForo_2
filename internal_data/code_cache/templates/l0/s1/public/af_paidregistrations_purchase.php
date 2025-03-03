<?php
// FROM HASH: 2b430c530372fc5c333d98fd5c0c276b
return array(
'macros' => array('payment_profile_selectrow' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'upgrade' => '!',
		'profiles' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['upgrade']['payment_profile_ids'])) {
		foreach ($__vars['upgrade']['payment_profile_ids'] AS $__vars['profileId']) {
			if ($__vars['profiles'][$__vars['profileId']]) {
				$__compilerTemp1[] = array(
					'value' => $__vars['profileId'],
					'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
					'_type' => 'option',
				);
			}
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'payment_profile_id',
	), $__compilerTemp1, array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['hasAliasUpgrades'] = $__templater->func('count', array($__vars['aliasUpgrades'], ), false);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ((!$__vars['hasAliasUpgrades']) AND (!$__vars['allowCustomAmount'])) {
		$__compilerTemp1 .= ' (' . $__templater->escape($__vars['accountType']['UserUpgrade']['cost_phrase']) . ')';
	}
	$__compilerTemp2 = '';
	if ($__vars['giftUser']) {
		$__compilerTemp2 .= ' (' . 'Gift Upgrade: ' . $__templater->escape($__vars['giftUser']['username']) . '' . ')';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account Type' . ': ' . $__templater->escape($__vars['accountType']['title']) . $__compilerTemp1 . $__compilerTemp2);
	$__finalCompiled .= '

';
	$__vars['formId'] = $__templater->func('unique_id', array('afprAccountType' . $__vars['accountType']['account_type_id'], ), false);
	$__finalCompiled .= '

';
	$__compilerTemp3 = '';
	if (!$__vars['xf']['visitor']['user_id']) {
		$__compilerTemp3 .= '
                ' . $__templater->formTextBoxRow(array(
			'name' => 'email',
			'type' => 'email',
		), array(
			'label' => 'Your email address',
		)) . '
            ';
	}
	$__compilerTemp4 = '';
	if ($__vars['allowCustomAmount']) {
		$__compilerTemp4 .= '
                ';
		$__compilerTemp5 = '';
		if ($__vars['accountType']['custom_amount_min'] > 0) {
			$__compilerTemp5 .= '
                            ' . 'Minimum amount' . ' ' . $__templater->filter($__vars['accountType']['custom_amount_min'], array(array('number', array(2, )),), true) . ' ' . ($__templater->escape($__vars['upgrade']['cost_currency']) ?: 'USD') . '
                        ';
		}
		$__compilerTemp4 .= $__templater->formTextBoxRow(array(
			'name' => 'custom_cost_amount',
			'type' => 'text',
			'size' => '5',
			'class' => 'input--inline',
		), array(
			'explain' => 'Please enter any amount you would like to pay for this upgrade.',
			'label' => '
                        ' . 'Custom Amount' . ' (' . ($__templater->escape($__vars['upgrade']['cost_currency']) ?: 'USD') . ')
                    ',
			'hint' => '
                        ' . $__compilerTemp5 . '
                    ',
			'html' => '
                        ' . $__templater->escape($__vars['accountType']['length_phrase']) . '
                    ',
		)) . '
            ';
	}
	$__compilerTemp6 = '';
	if ($__vars['hasAliasUpgrades']) {
		$__compilerTemp6 .= '
                ';
		$__compilerTemp7 = array();
		if ($__templater->isTraversable($__vars['aliasUpgrades'])) {
			foreach ($__vars['aliasUpgrades'] AS $__vars['alias_user_upgrade_id'] => $__vars['alias_upgrade']) {
				$__compilerTemp7[] = array(
					'value' => $__vars['alias_user_upgrade_id'],
					'selected' => ($__vars['alias_user_upgrade_id'] == $__vars['defaultAlias']),
					'label' => $__templater->escape($__vars['alias_upgrade']['title']) . ' (' . $__templater->escape($__vars['alias_upgrade']['cost_phrase']) . ($__vars['alias_upgrade']['length_unit'] ? '' : (' ' . 'Permanent')) . ')',
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp6 .= $__templater->formRadioRow(array(
			'name' => 'user_upgrade_id',
			'class' => 'user_upgrade_id',
		), $__compilerTemp7, array(
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose User Upgrade' . $__vars['xf']['language']['parenthesis_close'],
		)) . '
            ';
	} else {
		$__compilerTemp6 .= '
                ' . $__templater->formHiddenVal('user_upgrade_id', $__vars['upgrade']['user_upgrade_id'], array(
		)) . '
            ';
	}
	$__compilerTemp8 = '';
	if ($__vars['hasAliasUpgrades']) {
		$__compilerTemp8 .= '
                <div class="alias_profiles"></div>
            ';
	} else {
		$__compilerTemp8 .= '
                ';
		if ($__templater->func('count', array($__vars['upgrade']['payment_profile_ids'], ), false) == 1) {
			$__compilerTemp8 .= '
                    <div class="afprSinglePaymentMethod">
                        ' . $__templater->formRow('
                            ' . $__templater->escape($__vars['profiles'][$__vars['upgrade']['payment_profile_ids']['0']]) . '
                        ', array(
				'label' => 'Payment method',
			)) . '
                    </div>
                    ' . $__templater->formHiddenVal('payment_profile_id', $__vars['upgrade']['payment_profile_ids']['0'], array(
			)) . '
                ';
		} else {
			$__compilerTemp8 .= '
                    ' . $__templater->callMacro(null, 'payment_profile_selectrow', array(
				'upgrade' => $__vars['upgrade'],
				'profiles' => $__vars['profiles'],
			), $__vars) . '
                ';
		}
		$__compilerTemp8 .= '
            ';
	}
	$__compilerTemp9 = '';
	if ($__vars['giftUser'] AND $__vars['xf']['options']['af_paidregistrations_gift_upgrades_anon']) {
		$__compilerTemp9 .= '
                ' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'giftAnonymously',
			'value' => '1',
			'selected' => false,
			'label' => '
                        ' . 'Gift Anonymously' . '
                    ',
			'_type' => 'option',
		)), array(
			'explain' => 'If checked, the user will not see you gifted this upgrade.',
		)) . '
            ';
	}
	$__compilerTemp10 = '';
	if ($__vars['hasCoupons'] AND (!$__vars['allowCustomAmount'])) {
		$__compilerTemp10 .= '
                ' . $__templater->formRow('
                    ' . $__templater->formTextBox(array(
			'disabled' => ($__vars['hasAliasUpgrades'] ? 'disabled' : ''),
			'name' => 'coupon_code',
			'type' => 'text',
			'size' => '25',
			'class' => 'input--inline afpr_coupon_code',
		)) . '
                    ' . $__templater->button('Apply', array(
			'disabled' => ($__vars['hasAliasUpgrades'] ? 'disabled' : ''),
			'class' => ($__vars['hasAliasUpgrades'] ? 'is-disabled' : ''),
			'data-xf-click' => 'afpr-apply-coupon',
			'data-form-id' => $__vars['formId'],
			'data-account-type-id' => $__vars['accountType']['account_type_id'],
			'data-href' => $__templater->func('link', array('purchase/afpr-apply-coupon', ), false),
		), '', array(
		)) . '
                ', array(
			'label' => 'Coupon code',
			'explain' => 'If you have a coupon code, enter it here.',
		)) . '

                <div class="afpr_priceWithCoupon">
                    ' . $__templater->formRow('
                        <div class="afpr_new_price">' . 'New price' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['newPrice']) . '</div>
                    ', array(
			'label' => 'Price with coupon',
		)) . '
                </div>

            ';
	}
	$__compilerTemp11 = '';
	if ($__vars['isRegistration']) {
		$__compilerTemp11 .= '
            ' . $__templater->formHiddenVal('registration', '1', array(
		)) . '
        ';
	}
	$__compilerTemp12 = '';
	if ($__vars['giftUser']) {
		$__compilerTemp12 .= '
            ' . $__templater->formHiddenVal('giftUserId', $__vars['giftUser']['user_id'], array(
		)) . '
        ';
	}
	$__compilerTemp13 = '';
	if ($__vars['isExtend']) {
		$__compilerTemp13 .= '
            ' . $__templater->formHiddenVal('extend', '1', array(
			'class' => 'extend',
		)) . '
        ';
	}
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__compilerTemp3 . '
            ' . $__compilerTemp4 . '
            ' . $__compilerTemp6 . '

            ' . $__compilerTemp8 . '

            ' . $__compilerTemp9 . '

            ' . $__compilerTemp10 . '

        </div>
        ' . $__compilerTemp11 . '
        ' . $__compilerTemp12 . '
        ' . $__compilerTemp13 . '
        ' . $__templater->formHiddenVal('accountTypeId', $__vars['accountType']['account_type_id'], array(
	)) . '
        ' . $__templater->formSubmitRow(array(
		'submit' => 'Continue',
	), array(
		'rowtype' => '',
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('purchase', $__vars['upgrade'], ), false),
		'ajax' => 'true',
		'class' => 'block js-paymentForm',
		'data-xf-init' => 'payment-provider-container',
		'id' => $__vars['formId'],
	)) . '
<div class="js-paymentProviderReply-user_upgrade' . $__templater->escape($__vars['upgrade']['user_upgrade_id']) . '"></div>

' . '

';
	$__templater->inlineCss('
    .overlay-content > .block.js-paymentForm:first-child {
        margin-bottom: 0;
    }
    .afpr_priceWithCoupon
    {
        display: none;
    }
    .afpr_priceWithCoupon.is-active
    {
        display: block;
    }
');
	$__finalCompiled .= '

';
	if ((!$__vars['isRegistration']) AND ((!$__vars['allowCustomAmount']) AND ((!$__vars['hasCoupons']) AND ($__vars['hasOnlyPayPal'] AND $__templater->method($__vars['xf']['request'], 'isXhr', array()))))) {
		$__finalCompiled .= '
    ';
		$__templater->inlineCss('
        .overlay {
            display: none !important;
        }
    ');
		$__finalCompiled .= '
    ';
		$__templater->inlineJs('
        !function($, window, document, _undefined)
        {
            "use strict";

            // get the last one to avoid any issues
            $(\'form.js-paymentForm\').last().submit();
            XF.Modal.close();
        }
        (jQuery, window, document);
    ');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->inlineJs('
!function($, window, document, _undefined)
{
    "use strict";

    XF.AFPRApplyCouponClick = XF.Event.newHandler({
        eventNameSpace: \'AFPRApplyCouponClick\',
        options: {
            href: null,
            formId: null,
            accountTypeId: null,
            couponInput: \'.afpr_coupon_code\',
            extend: \'.extend\',
        },

        $form: null,
        $input: null,
        $extend: null,

        loading: false,

        init: function()
        {
            this.$form = $(\'form#\' + this.options.formId);
            this.$input = this.$form.find(this.options.couponInput);
            this.$extend = this.$form.find(this.options.extend);

            if (!this.$input.length)
            {
                console.error(\'Coupon field not found\');
            }
        },

        click: function(e)
        {
            e.preventDefault();

            if (this.loading)
            {
                return;
            }

            this.loading = true;

            var self = this;

            var checkedInput = \'input[type=radio][name=user_upgrade_id]:checked\',
                $upgrade = this.$form.find(checkedInput);

            if (!$upgrade.length)
            {
                $upgrade = this.$form.find(\'input[name="user_upgrade_id"]\');
            }

            var data = {
                code: this.$input.val(),
                upgradeId: $upgrade.val(),
                accountTypeId: this.options.accountTypeId,
                extend: this.$extend.val(),
            };

            XF.ajax(\'POST\', this.options.href, data, XF.proxy(this, \'loaded\'))
                .always(function() { self.loading = false; });
        },

        loaded: function(data)
        {
            if (data && data.valid)
            {
                this.$form.find(\'.afpr_priceWithCoupon\').addClass(\'is-active\');

                this.$form.find(\'.afpr_new_price\').text(data.newPrice + " (save: " + data.saving + ")");

                // form value is not sent if fully disabled
                this.$form.find(\'.afpr_coupon_code\').
                                addClass(\'is-disabled\').prop(\'readonly\', \'readonly\');

                this.$form.find(\'.afpr_coupon_code + button\').
                                addClass(\'is-disabled\').prop(\'readonly\', \'readonly\').attr(\'disabled\', \'disabled\');

                XF.flashMessage(data.message, 3000);
            }
        },
    });

    XF.Event.register(\'click\', \'afpr-apply-coupon\', \'XF.AFPRApplyCouponClick\');
}
(jQuery, window, document);
');
	$__finalCompiled .= '

';
	if ($__vars['hasAliasUpgrades']) {
		$__finalCompiled .= '
    ';
		$__templater->inlineJs('
        !function($, window, document, _undefined)
        {
            "use strict";

            var inputSelector = "form#' . $__templater->filter($__vars['formId'], array(array('escape', array('js', )),), false) . ' input[type=radio][name=user_upgrade_id]",
                inputCheckedSelector = inputSelector + \':checked\';

            $(inputSelector).change(function()
            {
                var $this = $(this),
                    user_upgrade_id = $(inputCheckedSelector).val();

                XF.ajax(\'post\', XF.canonicalizeUrl("' . $__templater->filter($__templater->func('link', array('purchase/afpr-alias-profiles', ), false), array(array('escape', array('js', )),), false) . '"), {user_upgrade_id: user_upgrade_id}, function (data)
                {
                    if (!data.html) return;
                    XF.setupHtmlInsert(data.html, function ($html, container, onComplete)
                    {
                        // only get the current one, no other open modals
                        var $old = $("form#' . $__templater->filter($__vars['formId'], array(array('escape', array('js', )),), false) . '").find(\'.alias_profiles\');
                        var $new = $html;

                        $new.hide().insertAfter($old);
                        $old.xfFadeUp(XF.config.speed.fast, function()
                        {
                            $old.remove();

                            if ($new.length)
                            {
                                XF.activate($new);
                                onComplete(false);
                            }

                            $new.xfFadeDown(XF.config.speed.fast, XF.layoutChange);

                            $new.parent().find(\'.afpr_coupon_code, .afpr_coupon_code + button\').
                                removeClass(\'is-disabled\').prop(\'disabled\', false);
                        });

                        return false; // onComplete is already handled above
                    });
                });
            });

            // auto load if we have a default checked
            $(inputCheckedSelector).trigger(\'change\');
        }
        (jQuery, window, document);
    ');
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);