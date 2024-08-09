// @ts-check
var AL = window.AL || {};

!function (XF, $, window, document, _undefined) {
    AL.FieldCounter = XF.Element.newHandler({
        maxLength: 0,
        length: 0,
        options: {
            maxLengthMessage: 'Number of characters left: {count}',
        },
        init: function () {
            const maxlength = this.$target.attr('maxlength');
            if (!maxlength || parseInt(maxlength, 10) === 0) {
                return;
            }

            this.maxlength = parseInt(maxlength, 10);

            this.createCounter();
            this.updateLength();

            this.$target.on('input', XF.proxy(this, 'updateCounter'));
        },
        createCounter: function () {
            let explain = this.$target.closest('dd').find('.formRow-explain');
            if (!explain.length) {
                explain = $('<div class="formRow-explain"></div>');
                this.$target.closest('dd').append(explain);
            }
            explain.append($('<div class="formRow-counter"></div>'));
        },
        updateLength: function () {
            this.length = this.$target.val().length;
            const length = Math.max(0, this.maxlength - this.length);
            this.$target.closest('dd').find('.formRow-counter').text(this.options.maxLengthMessage.replace('{count}', length));
        },
        updateCounter: function (evt) {
            this.updateLength();
            if (this.length >= this.maxlength) {
                evt.preventDefault();
                return false;
            }
            return true;
        }
    });

    XF.Element.register('al-field-counter', 'AL.FieldCounter');

    return true;
// @ts-ignore
}(window.XF, window.jQuery, window, document);