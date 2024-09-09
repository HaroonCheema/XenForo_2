var PB = window.PB || {};

!function ($, window, document)
{
	"use strict";
	PB.WithdrawPayoutForm = XF.Element.newHandler({

		options: {},

		init: function ()
		{
			var $input = this.$target.find('.js-requestedAmount');
			$input.on('change', XF.proxy(this, 'getAmount'));
		},

		getAmount: function (e)
		{
			var self = this;
			XF.ajax(
				'post',
				XF.canonicalizeUrl('index.php?withdraw/requisite/get-payout-sum'),
				self.$target.serialize(),
				XF.proxy(self, 'handleAjax'),
				{
					skipDefaultSuccessError: true
				}
			);
		},

		handleAjax: function (data)
		{
			if (data.errors || data.exception)
			{
				return;
			}

			var self = this;
			self.$target.find('.js-payoutAmount').html(data.amount);
			self.$target.find('.js-chargeAmount').html(data.charge_amount);
		}
	});

	XF.Element.register('pb-wq-payout-form', 'PB.WithdrawPayoutForm');

}(jQuery, window, document);
