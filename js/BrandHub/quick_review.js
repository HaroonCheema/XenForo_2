$(document).ready(function() 
{
    
	
	var brandDropdown = jQuery("select[name=brand_id]");
	var itemDropdown = jQuery("select[name=item_id]");
	var quickContentBody = jQuery(".quickContentBody");

	brandDropdown.on("change", OnBrandChange);
	
        itemDropdown.on("change", OnItemChange);
    
    
    
        function OnBrandChange(ev) 
        {

            quickContentBody.html('<div class="blockMessage">'+ XF.phrase('loading...') +'</div>');
            quickContentBody.hide();

            var brandId = jQuery("option:selected", this).val();

            console.log('change');
            console.log(brandId);

            var ajaxParams = {'brandId': brandId};

            XF.ajax(
                        'GET',
                        XF.canonicalizeUrl('index.php?bh-quick-review/get-brand-items'),
                        ajaxParams,
                        function (res) 
                        {

                                //itemDropdown.find("option:eq(0)").html("Please wait..");
                                itemDropdown.find("option:gt(0)").remove();

                                items = res.items;

                                jQuery.each(items, function(key, val) {
                                        itemDropdown.append('<option value="' + key + '">' + val + '</option>');
                                });

                                //itemDropdown.find("option:eq(0)").attr('disabled','disabled');
                        });
        }
        
        
        function OnItemChange(ev) 
        {
            quickContentBody.html('<div class="blockMessage">'+ XF.phrase('loading...') +'</div>');
            quickContentBody.show();
            var itemId = jQuery("option:selected", this).val();

            var ajaxParams = {'itemId': itemId};

            XF.ajax(
                    'GET',
                    XF.canonicalizeUrl('index.php?bh-quick-review/item-content'),
                    ajaxParams,
                    function (res) 
                    {
                        XF.setupHtmlInsert(res.html, function($html)
                        {
                                quickContentBody.html($html);
                        });
                    });
        }
	
	brandDropdown.trigger('change');
	
});





