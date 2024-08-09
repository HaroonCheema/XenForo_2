/** 
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/
var AddonsLab = AddonsLab || {};
!function ($, window, document, _undefined) {
    "use strict";

    $(document).on('filter:init', function (evt, $form) {

    });

    AddonsLab.ActiveFilterContainer = XF.Element.newHandler({
        init: function () {
            var $activeFilterContainer = this.$target;
            var targetSelector = $activeFilterContainer.attr('data-reload-target');

            $activeFilterContainer.closest('ul').on('click', '.filterBar-filterToggle', function (evt) {
                evt.preventDefault();
                requestUrl($(this).attr('href'), null, function (finalUrl, responseHtml, skipFormUpdate) {
                    updatePageContent(finalUrl, responseHtml, targetSelector, skipFormUpdate);
                }, true);
            });
        }
    });

    AddonsLab.FilterFormContainer = XF.Element.newHandler({

        options: {
            filterableListApi: null,
            filterableListAjaxLimit: 30,
        },

        init: function () {
            var $filterFormContainer = this.$target;

            // Register event handlers
            $(document).on('alff:request-start', XF.proxy(this, 'activateOverlay'));
            $(document).on('alff:request-completed', XF.proxy(this, 'deactivateOverlay'));
            $(document).on('alff:request-setup-completed', XF.proxy(this, 'deactivateOverlay'));

            var onVisible = XF.proxy(this.onVisible, this);

            // delay the initialization for some seconds giving time for other scripts to execute
            setTimeout(function () {
                var $form = $filterFormContainer.closest('form');

                $form.submit(function (evt) {
                    var form = this;
                    var isValid = form.reportValidity();
                    if (!isValid) {
                        evt.preventDefault();
                        return false;
                    }
                    return true;
                });

                $form.addClass('filterFormElement');
                // Move the configuration container to the end of the form, so it does not affect the CSS
                $form.append($filterFormContainer);

                $filterFormContainer.addClass('filterOverlay');
                // $filterFormContainer.append($('<i class="fas fa-spinner fa-spin"></i>'));
                // Activate the overlay till we are done initializing the form
                $filterFormContainer.addClass('activeOverlay');


                var targetSelector = $filterFormContainer.attr('data-reload-target');
                var autoReload = $filterFormContainer.attr('data-auto-reload') ? parseInt($filterFormContainer.attr('data-auto-reload')) : 0;
                if (!targetSelector) {
                    autoReload = 0;
                }
                var totalCountIndicator = $filterFormContainer.attr('data-total-count-indicator') ? parseInt($filterFormContainer.attr('data-total-count-indicator')) : 0;
                var filterableLists = $filterFormContainer.attr('data-filterable-lists') ? parseInt($filterFormContainer.attr('data-filterable-lists')) : 0;

                var timeout;

                function cancelReload() {
                    if (timeout) {
                        clearTimeout(timeout);
                    }
                }

                function registerReload($form, targetSelector, skipFormUpdate) {
                    if (timeout) {
                        clearTimeout(timeout);
                    }
                    timeout = setTimeout(function () {
                        reloadList($form, targetSelector, autoReload, totalCountIndicator, function (data) {
                            var reloadCompleteEvent = new $.Event('alff:reload-complete');
                            $form.trigger(reloadCompleteEvent, [data]);

                            if (reloadCompleteEvent.isDefaultPrevented()) {
                                return;
                            }

                            if (totalCountIndicator && data.hasOwnProperty('filterInfo')) {
                                var totalCount = data.filterInfo.total;
                                $form.find('.totalCountIndicator').show().find('span').html(totalCount);
                            }
                        }, skipFormUpdate);
                    }, 1000);
                }

                if ((targetSelector && autoReload) || totalCountIndicator) {

                    var formUpdateHandler = function (evt, skipFormUpdate) {
                        registerReload($form, targetSelector, skipFormUpdate);
                    };

                    $form.on('alff:submit-form', formUpdateHandler);

                    var select2Skipped = false;

                    function handleInputChange() {
                        if ($(this).closest('.select2-selection').length && $(this).val()) {
                            select2Skipped = true;
                            console.log('The input is part of select2, do not reload the form while user types in the selection field.');
                            console.log($(this).val());
                            cancelReload();
                            return;
                        }
                        select2Skipped = false;
                        if ($(this).closest('.filterReloadPreventedContainer').length) {
                            console.log('form reload is prevented');
                            return;
                        }

                        var changeEvent = jQuery.Event("alff:form-change", {originalTarget: this});
                        $(document).trigger(changeEvent);
                        if (changeEvent.isDefaultPrevented()) {
                            return;
                        }

                        formUpdateHandler(false);
                    }

                    $form.on('change', 'input,select', handleInputChange);

                    $form.on('select2:opening', 'select', function (evt) {
                        if ($(this).parent().find('.select2-search__field').val()) {
                            // User started to type another filter value, do not reload the form
                            cancelReload();
                        }
                    });
                    /*$form.on('select2:closing', 'select', function (evt) {
                        handleInputChange();
                    });*/

                    $(document).on('click', '.colorPicker-save', function () {
                        registerReload($form, targetSelector);
                    });
                }

                onVisible($form, filterableLists);

                $(document.body).on('xf:layout', function () {
                    onVisible($form);
                })

                $('.p-navgroup-link--filter').click(function () {
                    setTimeout(function () {
                        onVisible($form);
                    }, 500);
                });

                $filterFormContainer.removeClass('activeOverlay');

            }, 10);
        },
        activateOverlay: function () {
            this.$target.addClass('activeOverlay');
            // Remove all active selection lists whe reloading
            if ($('select.isFilterableSelect').length) {
                $('select.isFilterableSelect').select2('close');
            }
        },
        deactivateOverlay: function () {
            this.$target.removeClass('activeOverlay');
        },
        onVisible: function ($form, filterableLists) {
            if ($form.data('filterInit')) {
                return;
            }

            if (filterableLists) {
                var api_url = this.options.filterableListApi;
                // enhanced lists are enabled
                var $select = $form.find('.customFieldContainer div.inputGroup > select.input').not('.br-select').not('.noSelect2');
                $select.closest('div.inputGroup').addClass('hasFilterableSelect');
                $select.filter('[multiple]').find('option[value=\'\']').remove();
                // remove the unselected options from the list for performance boost
                // do this only if we have more than 100 options
                var useAjax = false;
                var $options = $select.find('option:not(:selected)');

                if ($options.length > this.options.filterableListAjaxLimit) {
                    $options.remove();
                    useAjax = true;
                }

                console.log(this.options.filterableListAjaxLimit);
                $select.addClass('isFilterableSelect');

                $select.each(function () {
                    var $el = $(this);
                    $el.select2({
                        dropdownCssClass: 'customFieldSelectionPopup',
                        language: {
                            errorLoading: function () {
                                return XF.phrase('s2_error_loading');
                            },
                            inputTooLong: function (args) {
                                return XF.phrase('s2_input_too_long', {
                                    '{count}': (args.input.length - args.maximum)
                                });
                            },
                            inputTooShort: function (args) {
                                return XF.phrase('s2_input_too_short', {
                                    '{count}': (args.minimum - args.input.length)
                                });
                            },
                            loadingMore: function () {
                                return XF.phrase('s2_loading_more');
                            },
                            maximumSelected: function (args) {
                                return XF.phrase('s2_maximum_selected', {
                                    '{count}': args.maximum
                                });
                            },
                            noResults: function () {
                                return XF.phrase('s2_no_results');
                            },
                            searching: function () {
                                return XF.phrase('s2_searching');
                            }
                        },
                        ajax: useAjax ? {
                            url: api_url,
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    select_name: $el.attr('name'),
                                    current_value: $el.val(),
                                    filter_action: 'load_options',
                                    page: params.page || 1
                                };
                                return query;
                            },
                            dataType: 'json'
                        } : undefined
                    });

                    $el.on('select2:opening', function (e) {
                        if ($el.data('unselecting')) {
                            $el.removeData('unselecting');
                            e.preventDefault();
                            /*setTimeout(function () {
                                $el.select2('close');
                            }, 1);*/
                        }
                    }).on('select2:unselecting', function (e) {
                        $el.data('unselecting', true);
                    });


                });

                $select
                    .closest('.customFieldContainer')
                    .addClass('filterSelectionContainer')
                    .find('.hasFilterableSelect .select2-container')
                    .addClass('input');
                $select.filter('[multiple]')
                    .closest('.customFieldContainer')
                    .addClass('multipleSelectionContainer');
                $select.not('[multiple]')
                    .closest('.customFieldContainer')
                    .addClass('singleSelectionContainer');
            }

            $form.data('filterInit', 1);

            // trigger a custom jQuery event
            $(document).trigger('filter:init', [$form]);
        }
    });

    XF.Element.register('filterFormContainer', 'AddonsLab.FilterFormContainer');
    XF.Element.register('activeFilterContainer', 'AddonsLab.ActiveFilterContainer');

    var requestInProgress;

    function reloadList($form, targetSelector, autoReload, requireTotalCount, rawCallback, skipFormUpdate) {
        console.log('Reloading list');
        // Close all select2 dropdowns, by filtering all select elements that have select2 data attached
        var $select = $form.find('select').filter(function () {
            return $(this).data('select2');
        });
        if ($select.length) {
            $select.select2('close');
        }

        if (requestInProgress) {
            requestInProgress.abort();
            requestInProgress = undefined;
        }
        var formData = $form.serializeArray();
        if (requireTotalCount) {
            formData.push({'name': 'includeTotalCount', 'value': 1});
        }

        requestUrl(
            $form.attr('action'),
            formData,
            function (finalUrl, responseHtml, skipFormUpdate) {
                if (autoReload && !requestInProgress) {
                    updatePageContent(finalUrl, responseHtml, targetSelector, skipFormUpdate);
                }
            },
            !!autoReload,
            rawCallback,
            skipFormUpdate
        );
    }

    function requestUrl(url, info, callback, followRedirect, rawCallback, skipFormUpdate) {
        var options = {skipDefaultSuccess: 1, skipDefaultSuccessError: 1, skipError: 1};
        if (info === null) {
            // shorthand for accessing raw html data
            info = [];
            options.dataType = 'html';
            options.skipDefault = true;
        }

        var startEvent = jQuery.Event("alff:request-start");
        $(document).trigger(startEvent);

        requestInProgress = XF.ajax('GET', url, info, function (data) {
            var completedEvent = jQuery.Event("alff:request-completed");
            $(document).trigger(completedEvent);

            requestInProgress = undefined;
            if (rawCallback) {
                rawCallback(data);
            }

            if (data.redirect) {
                if (followRedirect) {
                    requestUrl(data.redirect, null, callback, followRedirect, rawCallback, skipFormUpdate);
                }
                return;
            }

            if (typeof data === 'string') {
                // raw html loading mode
                callback(url, data, skipFormUpdate); // pass the entire body
                return;
            }

            if (!data.html) {
                return;
            }

            XF.setupHtmlInsert(data.html, function ($html) {
                var setupCompletedEvent = jQuery.Event("alff:request-setup-completed");
                $(document).trigger(setupCompletedEvent);
                callback(url, $('<div></div>').append($html).html());
            });
        }, options);
    }

    function updatePageContent(finalUrl, responseHtml, targetSelector, skipFormUpdate) {
        var $response = $('<div></div>').append(responseHtml);

        // Find all link rel=stylesheet elements in the response and append them to the document
        $response.find('link[rel=stylesheet]').each(function () {
            var $link = $(this);
            var href = $link.attr('href');
            if (href) {
                var $existing = $('link[rel=stylesheet][href="' + href + '"]');
                if (!$existing.length) {
                    $link.appendTo('head');
                }
            }
        });

        // if a filter form exists on the page and in the response, make the modification
        var filterFormSelector = '[data-xf-init*=\'filterFormContainer\']';

        var $filterForm = $(filterFormSelector).closest('form');

        var updatePageContentEvent = new $.Event('alff:update-page-content');

        $filterForm.trigger(updatePageContentEvent, [$response]);

        // take only one form from the response, just in case it has also the form for mobile
        var $replacementForm = $response.find(filterFormSelector).closest('form').first();

        if ($filterForm.length && $replacementForm.length && !skipFormUpdate) {
            // the response has the form and the page has the form, replace them
            $filterForm.replaceWith($replacementForm);
            var $form = $(filterFormSelector).closest('form');
            XF.activate($form);
        } else {
            // either the response did not have the form or the page does not have it,
            // nothing to do except closing the form if it was in popup to trigger reload from a URL
        }

        // Any addon defining a initMap method will be supported as the method will be executed and the map will update
        var mapUpdater = responseHtml.match(/<script.*?>[^<]*function initMap\(\)(.*?)<\/script>/s);
        if (mapUpdater) {
            mapUpdater = "window.updateMap = function()" + mapUpdater[1] + "; window.updateMap();console.log('map has been redrawn')";
            try {
                eval(mapUpdater);
            } catch (e) {
                // This happens when the page does not find the element as expected
                // the solution is to redirect to the target page where the element is found
                XF.redirect(finalUrl);
                return;
            }

            // a quick hack to sync filter bar as well
            var $responseFilterBar = $response.find('div[id^=map-]').closest('.block-container').find('.block-filterBar');
            var $documentFilterBar = $('div[id^=map-]').closest('.block-container').find('.block-filterBar');
            if ($responseFilterBar.length && $documentFilterBar.length) {
                $documentFilterBar.replaceWith($responseFilterBar);
                XF.activate($documentFilterBar);
            }
        } else if ($("[id^=map-]").length) {
            // We have a page with the map, but the response contains no map at all
            // We just remove the block, and if a page with map appears it will reload the page
            $("[id^=map-]").closest('.block').remove();
        }

        var $replaceList = $response.find(targetSelector).not('[data-widget-key]');
        var $currentList = $(targetSelector).not('[data-widget-key]');

        if ($replaceList.length && $currentList.length) {
            // the elements exist in the response and in the page, do the replacement
            $currentList.replaceWith($replaceList);
            XF.activate($(targetSelector));
        } else if (!mapUpdater) {
            // we could not find the element by the selector, and there is no map on the page
            // redirect to the final URL for users to see the page
            XF.redirect(finalUrl);
            return;
        }

        setUrl(finalUrl);
    }

    function setUrl(url) {
        if (window.history.replaceState) {
            //prevents browser from storing history with each change:
            window.history.replaceState({}, null, url);
        }
    }

}(jQuery, window, document);
