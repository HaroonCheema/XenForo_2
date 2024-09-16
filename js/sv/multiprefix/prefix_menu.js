var SV = window.SV || {};
SV.MultiPrefix = SV.MultiPrefix || {};

// noinspection JSUnusedLocalSymbols
(function ($, window, document, _undefined)
{
    "use strict";

    $.extend(SV.MultiPrefix, {
        svMultiPrefixCounter: 1
    });

    $.fn.extend({
        multiPrefixSelectorUniqueId: function ()
        {
            var id = this.attr('id');
            if (!id)
            {
                id = 'js-SVMultiPrefixUniqueId' + SV.MultiPrefix.svMultiPrefixCounter;
                this.attr('id', id);
                this.attr('data-sv-multiprefix-unique', SV.MultiPrefix.svMultiPrefixCounter);
                SV.MultiPrefix.svMultiPrefixCounter++;
            }

            return id;
        }
    });

    SV.MultiPrefix.Helpers = {
        getHiddenInputName: function ($input, forSelector)
        {
            forSelector = forSelector === undefined ? false : forSelector;

            let hiddenInputName = ($input.attr('name') + '_internal').replace('[]', '');

            if (!forSelector)
            {
                return hiddenInputName;
            }

            return '[name="' + hiddenInputName + '"]';
        },
    };

    SV.MultiPrefix.PrefixMenu = XF.Element.newHandler({
        options: {
            realInput: null,

            // these exist for the sole purpose of existing
            minTokens: 0,
            maxTokens: 0,
        },

        init: function ()
        {
            var $input = this.$target;

            this.template = this.$target.parent().find('script[type="text/template"]').html();
            if (!this.template)
            {
                console.error('No prefix template could be found');
                this.template = '';
            }

            $input.on('config-update', $.proxy(this, 'setupSelect2'));
            $input.trigger('config-update');
        },

        loadPrefixes: function ()
        {
            var prefixes = [];

            this.$target.find('option').each(function ()
            {
                var $opt = $(this);

                prefixes[$opt.attr('value')] = {
                    prefix_id: $opt.attr('value'),
                    title: $opt.text(),
                    css_class: $opt.attr('data-prefix-class')
                };
            });

            this.prefixes = prefixes;
        },

        getSelectedPrefixIds: function ()
        {
            // force multiple argument just in case
            this.$target.prop('multiple', true);

            var prefixIds = this.$target.val();
            if (typeof prefixIds === 'string')
            {
                return [parseInt(prefixIds)];
            }

            return prefixIds;
        },

        getMinTokens: function ()
        {
            return this.getAllowedTokensCount('min');
        },

        getMaxTokens: function ()
        {
            return this.getAllowedTokensCount('max');
        },

        getAllowedTokensCount: function (prefix)
        {
            let $input = this.$target,
                key = prefix + '-tokens',
                allowedTokensCount = $input.data(key);

            if (allowedTokensCount === undefined)
            {
                allowedTokensCount = $input.attr('data-' + key);
                if (allowedTokensCount === undefined)
                {
                    allowedTokensCount = 0;
                }
            }

            return allowedTokensCount;
        },

        hasTooManyItems: function ()
        {
            let maxTokens = this.getMaxTokens();
            if (!maxTokens)
            {
                return false;
            }

            return this.getSelectedPrefixIds().length > maxTokens;
        },

        getSelect2Config: function ()
        {
            return {
                language: SV.MultiPrefix.Phrases,
                width: '100%',
                minimumSelectionLength: this.getMinTokens() ,
                maximumSelectionLength: this.getMaxTokens(),
                containerCssClass: 'input prefix--title',
                selectOnClose: false,
                placeholder: XF.phrase('sv_prefix_placeholder', null, "Prefix..."),
                disabled: this.$target.prop('disabled'),
                templateResult: $.proxy(this, 'renderPrefix'),
                templateSelection: $.proxy(this, 'renderPrefix'),
                dropdownParent: this.$target.parent(),
                dropdownCssClass: 'select2-dropdown--forceHide',
                debug: false
            };
        },

        getSelect2Api: function ()
        {
            return this.$target.data('select2');
        },

        autoFocusIfNeeded: function ()
        {
            let $input = this.$target;
            if (!$input.prop('autofocus'))
            {
                return;
            }

            $input.select2('open');
        },

        handleInOverlayStateIfNeeded: function ()
        {
            let $overlay = this.$target.closest('.overlay-container');
            if (!$overlay.length)
            {
                return;
            }

            let self = this;
            $overlay.on('overlay:hiding', function ()
            {
                self.$target.select2('close');
            });
        },

        getSearchField: function ()
        {
            return this.$target.parent().find('.select2-selection');
        },

        signalTooManyItemsIfNeeded: function()
        {
            if (!this.hasTooManyItems())
            {
                return;
            }

            var $searchField = this.getSearchField();
            if (!$searchField.length)
            {
                return;
            }

            setTimeout(function ()
            {
                $searchField.trigger('click');
            });
        },

        getHiddenInputName: function (forSelector)
        {
            forSelector = forSelector === undefined ? false : forSelector;

            let hiddenInputName = (this.$target.attr('name') + '_internal').replace('[]', '');

            if (!forSelector)
            {
                return hiddenInputName;
            }

            return '[name="' + hiddenInputName + '"]';
        },

        prepareInput: function ()
        {
            let $input = this.$target,
                $noneOption = $input.find('option[value="0"]');

            $input.multiPrefixSelectorUniqueId();
            if ($input.data('select2'))
            {
                $input.select2('destroy');
            }

            if ($noneOption.length)
            {
                return; // already prepared
            }

            $noneOption = $('<option', {
                value: 0
            }).text(XF.phrase('sv_multiprefix_none', null, "(None)"));

            $input.prepend($noneOption);
            $input.prop('multiple', true);
            $input.on('change', XF.proxy(this, 'handleNoneValue'));
        },

        isFauxSingleMode: function ()
        {
            return !this.hasTooManyItems() && this.getMaxTokens() === 1;
        },

        initSelect2: function ()
        {
            let self = this,
                $input = this.$target,
                select2Config = this.getSelect2Config();

            $input.select2(select2Config);

            $input.on('select2:opening', function ()
            {
                if (!self.isFauxSingleMode())
                {
                    return;
                }

                let selectedPrefixIds = self.getSelectedPrefixIds().join(','),
                    $hiddenInput = $('<input>').attr({
                        type: 'hidden',
                        name: SV.MultiPrefix.Helpers.getHiddenInputName($input),
                    });

                $hiddenInput.val(selectedPrefixIds);
                $hiddenInput.insertAfter($input);
                $input.val([]);
            });

            $input.on('select2:closing', function ()
            {
                if (!self.isFauxSingleMode())
                {
                    return;
                }

                let hiddenInputName = SV.MultiPrefix.Helpers.getHiddenInputName($input),
                    $hiddenInput = XF.findRelativeIf(hiddenInputName, $input);

                if (!$hiddenInput.length)
                {
                    return;
                }

                $input.val($hiddenInput.val());
                $hiddenInput.remove();
            });

            $input.on('select2:unselecting', function (e)
            {
                XF.MenuWatcher.preventDocClick();
            });

            $input.on('select2:unselect', function (e)
            {
                setTimeout(function ()
                {
                    XF.MenuWatcher.allowDocClick();
                }, 0);
            });
        },

        setupSelect2: function ()
        {
            this.prepareInput();
            this.loadPrefixes();
            this.initSelect2();
            this.signalTooManyItemsIfNeeded();
            this.autoFocusIfNeeded();
            this.handleInOverlayStateIfNeeded();
        },

        renderPrefix: function (state)
        {
            if (!state.id || this.template === '')
            {
                return state.text;
            }

            return $(Mustache.render(this.template, {rich_prefix: this.prefixes[state.id]}));
        },

        handleNoneValue: function (e)
        {
            let $select = $(e.currentTarget),
                $noneOption = $select.find('option[value=""]')

            if (!$noneOption.length || !$noneOption.prop('selected'))
            {
                return;
            }

            $noneOption.prop('selected', false);
        }
    });

    SV.MultiPrefix.Phrases = {
        errorLoading: function()
        {
            return XF.phrase('s2_error_loading');
        },
        inputTooLong: function(args)
        {
            return XF.phrase('s2_input_too_long', {
                '{count}': (args.input.length - args.maximum)
            });
        },
        inputTooShort: function(args)
        {
            return XF.phrase('s2_input_too_short', {
                '{count}': (args.minimum - args.input.length)
            });
        },
        loadingMore: function()
        {
            return XF.phrase('s2_loading_more');
        },
        maximumSelected: function(args)
        {
            return XF.phrase('s2_maximum_selected', {
                '{count}': args.maximum
            });
        },
        noResults: function()
        {
            return XF.phrase('s2_no_results');
        },
        searching: function()
        {
            return XF.phrase('s2_searching');
        }
    };

    SV.MultiPrefix.PrefixLoader = XF.Element.newHandler({
        options: {
            listenTo: '',
            initUpdate: true,
            href: '',
            uniqueId: '',
        },

        init: function ()
        {
            if (!this.$target.is('select'))
            {
                console.error('Must trigger on select');
                return;
            }

            this.options.uniqueId = this.$target.multiPrefixSelectorUniqueId();

            if (this.options.href)
            {
                var $listenTo = this.options.listenTo ? XF.findRelativeIf(this.options.listenTo, this.$target) : $([]);
                if (!$listenTo.length)
                {
                    console.error('Cannot load prefixes dynamically as no element set to listen to for changes');
                    return;
                }

                $listenTo.on('change', $.proxy(this, 'loadPrefixes'));
                if (this.options.initUpdate)
                {
                    $listenTo.trigger('change');
                }
            }
        },

        loadPrefixes: function (e)
        {
            XF.ajax('POST', this.options.href, {
                val: $(e.target).val()
            }, $.proxy(this, 'loadSuccess'));
        },

        loadSuccess: function (data)
        {
            if (data.html)
            {
                var $select = this.$target,
                    val = $select.val(),
                    hiddenInputSelector = SV.MultiPrefix.Helpers.getHiddenInputName($select),
                    $hiddenInput = XF.findRelativeIf(hiddenInputSelector, $select);

                if ($hiddenInput.length)
                {
                    if ($select.data('select2'))
                    {
                        $select.select2('destroy');
                    }

                    // undo the faux single mode
                    val = $hiddenInput.val();
                    $select.val(val.split(','));
                    $hiddenInput.remove();
                }

                XF.setupHtmlInsert(data.html, function ($html)
                {
                    var $tmpSelect = $html.find('select');
                    if ($tmpSelect.length)
                    {
                        $select.empty().append($tmpSelect.children());
                        if (val)
                        {
                            $select.val([]);
                            $.each(val, function (index, value)
                            {
                                $select.find('option[value="' + value + '"]').attr('selected', 'selected').prop('selected', true);
                            });
                        }

                        var minTokens = parseInt($tmpSelect.data('min-tokens')),
                            maxTokens = parseInt($tmpSelect.data('max-tokens'));

                        $select.data('min-tokens', minTokens).data('max-tokens', maxTokens);

                        if ($select.find('option:selected').length > maxTokens)
                        {
                            // remove prefixes than allowed?
                        }

                        $select.attr('multiple', 'multiple');
                        $select.trigger('config-update');
                    }

                    $html.empty();
                });
            }
        }
    });

    if (XF.QuickThread)
    {
        XF.Element.extend('quick-thread', {
            __backup: {
                'reset': 'svMultiPrefix_reset'
            },

            reset: function (e, onComplete)
            {
                $('select[name="prefix_id[]"]').val('').trigger('change');
                // noinspection Annotator
                this.svMultiPrefix_reset(e, onComplete);
            }
        });
    }

    XF.Element.register('sv-multi-prefix-loader', 'SV.MultiPrefix.PrefixLoader');
    XF.Element.register('sv-multi-prefix-menu', 'SV.MultiPrefix.PrefixMenu');
}(jQuery, window, document));