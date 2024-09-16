!function($, window, document, _undefined)
{
    "use strict";
    XF.BriviumIconPicker = XF.Element.newHandler({
        options: {
            inputClass: '< dd | input.icon',
            inputContent: '< dd | input.content',
            fontFamily: '< dd | input.fontFamily',
            config: {},
        },
        $iconPicker: null,
        init: function()
        {
            this.$inputClass = XF.findRelativeIf(this.options.inputClass, this.$target);
            this.$inputContent = XF.findRelativeIf(this.options.inputContent, this.$target);
            this.$fontFamily = XF.findRelativeIf(this.options.fontFamily, this.$target);

            this.$iconPicker = this.$target.iconpicker(this.options.config);
            this.$iconPicker.on('change', XF.proxy(this, 'onChange'));
            this.$iconPicker.trigger('change');
        },
        onChange: function (event) {
            if(event.icon)
            {
                this.$inputClass.val(event.icon);
            }
            var $faIcon = XF.findRelativeIf('> i', this.$target),
                $before = window.getComputedStyle($faIcon[0],':before'),
                content = $before.content,
                fontFamily = $before.fontFamily;

            content = content.replace(/['"]/g, '');
            fontFamily = fontFamily.replace(/['"]/g, '');

            this.$inputContent.val(content);
            this.$fontFamily.val(fontFamily);
        }
    });

    XF.Element.register('brivium-icon-picker', 'XF.BriviumIconPicker');
}
(jQuery, window, document);