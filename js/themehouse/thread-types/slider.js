var XFMG = window.XFMG || {};

!function($, window, document, _undefined)
{
	"use strict";

	XF.ThttSlider = XF.Element.newHandler({
		options: {
			uuid: null,
			auto: false,
			loop: true,
			pager: true,
			item: 1,
		},

		init: function()
		{
			var swiper = new Swiper('#' + this.options.uuid, {
				// Optional parameters
				autoHeight: true,
				loop: true,
				effect: 'slide',
				dynamicBullets: true,

				// If we need pagination
				pagination: {
					el: '.swiper-pagination',
					clickable: true
				},
			});
		}
	});

	XF.Element.register('thtt-slider', 'XF.ThttSlider');
}
(jQuery, window, document);