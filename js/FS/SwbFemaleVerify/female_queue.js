var PB = window.PB || {};

!function ($, window, document)
{
	"use strict";

	PB.WithdrawControlClick = XF.Event.newHandler(
		{
			eventType: 'click',
			eventNameSpace: 'PBWithdrawControlClick',
			options: {
				container: '.withdrawalQueue-item'
			},

			$item: null,
			value: null,

			init: function ()
			{
				this.$item = this.$target.closest(this.options.container);
				this.value = this.$target.val();
			},

			click: function (e)
			{
				this.$item
					.toggleClass('withdrawalQueue-item--sent', this.value == 'sent')
					.toggleClass('withdrawalQueue-item--rejected', this.value == 'rejected');
			}
		});

	XF.Event.register('click', 'pb-wq-withdraw-control', 'PB.WithdrawControlClick');

}(jQuery, window, document);
