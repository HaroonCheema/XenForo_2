// @ts-check

const AL = window.AL || {};

!function (XF, $, window, document, _undefined) {
    AL.DisabledButton = XF.Element.newHandler({
        init: function () {
            this.$target.click(XF.proxy(this, 'click'));
        },
        click: function (e) {
            if (this.$target.hasClass('is-disabled')) {
                e.preventDefault();
                return false;
            }
            return true;
        }
    });

    XF.Element.register('al-disabled-button', 'AL.DisabledButton');

    return true;
// @ts-ignore
}(window.XF, window.jQuery, window, document);