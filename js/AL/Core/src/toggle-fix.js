/**
 * Fixes the issue with XF toggle control triggering the submit event twice, once on the label once on the input
 */
// @ts-check

const AL = window.AL || {};

!function (XF, $, window, document, _undefined) {
    XF.SubmitClick = XF.extend(XF.SubmitClick, {
        __backup: {
            'click': 'addonslabToggleFixClick'
        },
        click: function (e) {
            if (!this.$input.is(e.target)) {
                return;
            }
            console.log(e);
            this.addonslabToggleFixClick();
        }
    });
    return true;
// @ts-ignore
}(window.XF, window.jQuery, window, document);

