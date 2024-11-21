!function($, window, document, _undefined)
{
    "use strict";

    XF.XBgalleryavatar = XF.Click.newHandler({
        eventNameSpace: 'XBgalleryavatar',

        init: function() {},

        click: function(e)
        {
            e.preventDefault();

            $('#xb_avatar_choice').val($(e.currentTarget).data('avatar-data-path'));

            if ($(e.currentTarget).hasClass('checked'))
            {
                $('#xb_avatar_choice').val('');
                $('div#xb_avatar_select').removeClass('checked');
            }
            else
            {
                $('div#xb_avatar_select').removeClass('checked');
                $(e.currentTarget).addClass('checked');
            }
        }
    });

    XF.Click.register('xb_avatar', 'XF.XBgalleryavatar');
}
(jQuery, window, document);
