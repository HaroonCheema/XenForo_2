/**
 * Fixes the issue with XF toggle control triggering the submit event twice, once on the label once on the input
 */
// @ts-check

const AL = window.AL || {};

!function (XF, $, window, document, _undefined) {
    XF.Carousel = XF.extend(XF.Carousel, {
        __backup: {
            'init': 'addonslabInit'
        },
        init: function () {
            // noinspection JSUnresolvedReference
            const breakpointSetup = this.$target.data('breakpoint-setup');
            if (breakpointSetup) {
                this.breakpoints = {
                    ...this.breakpoints,
                    ...breakpointSetup
                };
            }
            // noinspection JSUnresolvedReference
            this.addonslabInit();
        }
    });
    return true;
// @ts-ignore
}(window.XF, window.jQuery, window, document);

