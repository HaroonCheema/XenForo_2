!function ($, window, document, _undefined)
{
    XenForo.BbCodeWysiwygEditor.prototype._adjustButtonConfig = function (config, extraButtons)
    {
        var self = this,
                extra = [];

        for (var i in extraButtons)
        {
            if (!extraButtons.hasOwnProperty(i))
            {
                continue;
            }

            (function (i) {
                var button = extraButtons[i];

                config.buttonsCustom[i] = {
                    title: self.getText(i, button.title),
                    callback: function (ed)
                    {
                        if (button.exec)
                        {
                            ed.execCommand(button.exec);
                        }
                        else if (button.tag)
                        {
                            var tag = button.tag;
                            self.wrapSelectionInHtml(ed, '[' + tag + ']', '[/' + tag + ']', true);
                        }
                        else if (button.callback)
                        {
                            self[button.callback](ed);
                        }
                    }
                };

                extra.push(i);
            })(i);
        }

        if (extra.length)
        {
            config.buttons.push(extra);
        }

        return config;
    };

    XenForo.BbCodeWysiwygEditor.prototype.toggleSymbols = function (ed)
    {
        var self = this,
                $symbols = ed.$box.find('.redactor_symbols');

        if ($symbols.length)
        {
            $symbols.slideToggle();
            return;
        }

        if (self.symbolsPending)
        {
            return;
        }
        self.symbolsPending = true;

        XenForo.ajax(
                'index.php?editor/symbols',
                {},
                function (ajaxData) {
                    if (XenForo.hasResponseError(ajaxData))
                    {
                        return;
                    }

                    if (ajaxData.templateHtml)
                    {
                        $symbols = $('<div class="redactor_symbols" />').html(ajaxData.templateHtml);
                        $symbols.hide();
                        $symbols.on('click', '.Symbol', function (e) {
                            e.preventDefault();

                            var $symbol = $(this),
                                    html = $.trim($symbol.html());

                            ed.execCommand('inserthtml', html);
                            ed.focus();
                        });
                        ed.$box.append($symbols);
                        $symbols.xfActivate();
                        $symbols.slideToggle();
                    }
                }
        ).complete(function () {
            self.symbolsPending = false;
        });
    };

}(jQuery, this, document);