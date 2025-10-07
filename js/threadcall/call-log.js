var ThreadCaller = ThreadCaller || {};

((window, document) => {
    "use strict";

    ThreadCaller.PushButton = XF.Element.newHandler({
        init() {
            const button = this.target;
            const threadId = button.getAttribute('data-thread-id');
            const actionType = button.getAttribute('data-action-type'); // 'call' or 'whatsapp'

            if (!threadId || !actionType) {
                console.error('ThreadCaller: Missing thread ID or action type');
                return;
            }

            button.addEventListener('click', (e) => {
                e.preventDefault();

                // Prevent double clicks
                if (button.classList.contains('is-processing'))
                    return;
                button.classList.add('is-processing');

                // Detect Safari (desktop/iOS)
                const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

                // Open blank window immediately ONLY for Safari + WhatsApp
                let openedWindow;
                if (actionType === 'whatsapp' && isSafari) {
                    openedWindow = window.open('', '_blank');
                }

                // AJAX log request
                XF.ajax(
                        'POST',
                        XF.canonicalizeUrl('threads/push-log'),
                        {
                            thread_id: threadId,
                            action_type: actionType
                        },
                        function (data) {
                            button.classList.remove('is-processing');

                            if (data.results && data.results.redirectUrl) {
                                // Show flash message for 1 second
                                

                                if (openedWindow && isSafari) {
                                    // Safari-safe: redirect in popup
                                    setTimeout(() => {
                                        openedWindow.location.href = data.results.redirectUrl;
                                    }, 1000); // show flash for 1 second first
                                    
                                } else {
                                    // Show flash first
                                    if (data.results.message) {
                                        XF.flashMessage(data.results.message, 2000); // show flash
                                    }

                                    // Delay redirect slightly to let flash render
                                    setTimeout(() => {
                                        if (actionType === 'whatsapp') {
                                            window.open(data.results.redirectUrl, '_blank');
                                        } else if (actionType === 'call') {
                                            window.location.href = data.results.redirectUrl;
                                        } else {
                                            window.location.href = data.results.redirectUrl;
                                        }
                                    }, 1200); // very short delay to let flash show
                                }

                            } else {
                                XF.flashMessage(data.error || 'Action failed', 3000);
                            }
                        },
                        {skipDefaultSuccess: true}
                );
            });
        }
    });

    // Register the handler with XF.Element
    XF.Element.register('thread-call-log', 'ThreadCaller.PushButton');

})(window, document);
