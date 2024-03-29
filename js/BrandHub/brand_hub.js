var BrandHub = window.BrandHub || {};

!function($, window, document)
{	
	// ##################################################################################
	
	BrandHub.PageNav = XF.Element.newHandler(
	{
		$target: null,
		
		init: function()
		{
			$target = this.$target;
			
			$target.on('click', '.pageNavWrapper a', $.proxy(this, 'reviewsClick'));
		},
		
		reviewsClick: function(e)
		{
			e.preventDefault();
			
			if ($(e.currentTarget).attr('href'))
			{
				XF.ajax('get', $(e.currentTarget).attr('href'), {}, function(data)
				{
					if (data.html)
					{
						XF.setupHtmlInsert(data.html, this.$target);
					}
				});
			}
		},
	});
        // 


        XF.Element.register('xb-bh-pagenav', 'BrandHub.PageNav');
}
(window.jQuery, window, document);