!function($, window, document, _undefined)
{
    "use strict";

    XF.BRATRRating = XF.extend(XF.Rating, {
        __backup: {
            'init': '_init',
            'loadOverlay': '_loadOverlay'
        },
        _options: {
            widgetClass: null,
            voteContent: null,
            voteClass: 'bratr-vote-content'
        },
        init: function()
        {
            this.options = XF.applyDataOptions(this._options, this.$target.data(), this.options);
            this._init.apply(this, arguments);

            var $widget = this.$target.next('.br-widget');
            if(this.options.widgetClass)
            {
                $widget.addClass(this.options.widgetClass);
            }

            if(this.options.voteContent)
            {
                if($widget.find('.br-current-rating').length)
                {
                    this.$voteContent = XF.findRelativeIf('.br-current-rating', $widget);
                    this.$voteContent.addClass(this.options.voteClass).html(this.options.voteContent);
                }else
                {
                    this.$voteContent = $('<div></div>').addClass(this.options.voteClass).html(this.options.voteContent);
                    $widget.append(this.$voteContent);
                }

                XF.activate(this.$voteContent);

                var width = $widget.width();
                $widget.css('min-width', Math.max(width, 180) +'px');
            }

            if(this.options.readonly || !this.options.showSelected || !this.$voteContent)
            {
                return;
            }
            $widget.on('mouseleave', XF.proxy(this, 'eMousseLeave'));
        },
        loadOverlay: function(data)
        {
            if(data.message && data.redirect)
            {
                XF.flashMessage(data.message, 1000, function()
                {
                    XF.redirect(data.redirect);
                });
            }else if(data.message)
            {
                XF.flashMessage(data.message, 1000);
            }else if(data.redirect)
            {
                XF.redirect(data.redirect);
            }

            return this._loadOverlay.apply(this, arguments);
        },
        eMousseLeave: function(e)
        {
            this.$voteContent.html(this.options.voteContent);
            XF.activate(this.$voteContent);
        }
    });
    XF.Element.register('rating', 'XF.BRATRRating');
}
(jQuery, window, document);