/**
 * Fixes the issue with XF toggle control triggering the submit event twice, once on the label once on the input
 */
// @ts-check

const AL = window.AL || {};
/**
 * For the custom delay to work on any link, clicking which we immediately get a redirect response:
 * 1. message-with-delay key in the JSON response (used to stop the default message)
 * 2. data-force-flash-message="on" and data-follow-redirects="on" on the link
 * 3. Additional attribute on the link to define the length of message - data-message-timeout="3000"
 *
 * For the custom delay to work on a form, simply add data-redirect-timeout="3000"
 * to other data attributes of "ajax-submit" form
 */
!function (XF, $, window, document, _undefined) {
    $(document).on('ajax-submit:response', function (evt, data) {
        const $target = $(evt.target);
        const handler = XF.Element.getHandler($target, 'ajax-submit');
        const $overlay = $target.closest('.overlay');
        const doRedirect = data.redirect && handler.options.redirect;
        if (
            handler
            && $target.attr('data-redirect-timeout')
            && data.status === 'ok'
            && doRedirect
            && handler.options.forceFlashMessage
            && data.message
        ) {
            evt.preventDefault();
            XF.flashMessage(data.message, $target.attr('data-redirect-timeout'), function () {
                XF.redirect(data.redirect);
            });
        }
    });

    $(document).on('ajax:before-success', function (evt, data) {
        if (
            data && data.status === 'ok' && data.message
            && data.hasOwnProperty('message-with-delay')
        ) {
            // Store the original message
            data['message-with-timeout'] = data.message;
            // remove it to prevent the default message from appearing
            data.message = '';
        }
    });
    XF.OverlayClick = XF.extend(XF.OverlayClick, {
        __backup: {
            'show': 'addonslabOverlayClickShow',
            'init': 'addonslabOverlayClickInit',
        },
        init: function () {
            this.addonslabOverlayClickInit();
            var messageTimeout = this.$target.data('messageTimeout');
            this.options.messageTimeout = messageTimeout ? parseInt(messageTimeout) : null;
        },
        show: function () {
            if (this.options.messageTimeout === null || this.overlay || this.loading || !this.options.followRedirects) {
                // In any of those cases our fix would not apply anyway
                this.addonslabOverlayClickShow();
                return;
            }

            var messageTimeout = this.options.messageTimeout;

            console.log('Delaying redirect for ' + messageTimeout + 'ms');

            // This code is a copy has we had to change the messageTimeout to a configurable number
            this.loading = true;

            var t = this,
                options = {
                    cache: this.options.cache,
                    beforeShow: function (overlay) {
                        t.overlay = overlay;
                    },
                    init: XF.proxy(this, 'setupOverlay')
                },
                ajax;

            if (this.options.followRedirects) {
                options['onRedirect'] = function (data, overlayAjaxHandler) {
                    if (t.options.forceFlashMessage) {
                        XF.flashMessage(data.message || data['message-with-timeout'], messageTimeout, function () {
                            XF.redirect(data.redirect);
                        });
                    } else {
                        XF.redirect(data.redirect);
                    }
                };
            }

            ajax = XF.loadOverlay(this.loadUrl, options, this.options.overlayConfig);

            if (ajax) {
                ajax.always(function () {
                    setTimeout(function () {
                        t.loading = false;
                    }, 300);
                });
            } else {
                this.loading = false;
            }

        }
    });
    return true;
// @ts-ignore
}(window.XF, window.jQuery, window, document);

