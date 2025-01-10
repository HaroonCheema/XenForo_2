!function($, window, document)
{
  "use strict";

  XF.AIBotsHandlerTabsLoader = XF.Element.newHandler({
    options: {
      link: '',
      firstLoad: true
    },

    init: function() {
      this.$form = this.$target.closest('form');
      this.$tabsContainer = this.$form.find('.js-aibTabs');
      this.$tabPanesContainer = this.$form.find('.js-aibTabPanes');
      this.$target.change(XF.proxy(this, 'loadTabs'));

      if (this.options.firstLoad) {
        this.loadTabs();
      }
    },

    loadTabs () {
      const botClass = this.$target.val();
      if (!botClass.length) {
        return;
      }

      let params = { };
      params[this.$target.attr('name')] = botClass;

      XF.ajax('GET',
        this.options.link,
        params,
        ( data ) => {
          this.clearTabs()
          this.clearTabPanes();

          if (data.html && data.html.content) {
            XF.setupHtmlInsert(data.html, $html => {
              this.replaceTabPanes($html);
            });
          }

          if (data.tabs) {
            this.updateTabs(data.tabs);
          }
        }
      );
    },

    updateTabs ( tabs ) {
      const newTabs = [];
      for (let i = 0; i < tabs.length; i++) {
        const tab = tabs[i];
        const $tab = $(`<a class="tabs-tab" role="tab" tabindex="${i+1}" aria-controls="${tab.id}">${tab.title}</a>`);
        newTabs.push($tab);
      }
      XF.activate(this.$tabsContainer.find('.hScroller-scroll').append(...newTabs));
      XF.Element.getHandler(this.$tabsContainer, 'tabs').init();
    },

    clearTabs () {
      $('.js-aibTabs > .hScroller-scroll > a:not([data-protected])').remove();
    },

    replaceTabPanes ( $panes ) {
      XF.activate($panes.appendTo(this.$tabPanesContainer));
    },

    clearTabPanes () {
      $('.js-aibTabPanes > li:not([data-protected])').remove();
    }
  });

  XF.Element.register('aib-handler-tabs-loader', 'XF.AIBotsHandlerTabsLoader');
}
(window.jQuery, window, document);