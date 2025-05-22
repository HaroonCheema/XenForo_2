var PFES = window.PFES || {};

!(function ($, window, document, _undefined) {
  "use strict";

  PFES.editorButton = {
    registerButtonCommands: function () {
      $.FE.PLUGINS.pfEsSymbols = function (editor) {
        var initialized = false;
        var loaded = false;

        var $menu,
          $menuScroll,
          scrollTop = 0,
          flashTimeout;

        function showMenu() {
          selectionSave();

          XF.EditorHelpers.blur(editor);

          var $btn = editor.$tb.find('.fr-command[data-cmd="pfEsAddSymbol"]');

          if (!initialized) {
            initialized = true;

            $menu = $(
              $.parseHTML(
                Mustache.render($(".js-editorPfEsSymbolsMenu").first().html())
              )
            );
            $menu.insertAfter($btn);

            $btn.data("xf-click", "menu");

            var handler = XF.Event.getElementHandler($btn, "menu", "click");

            $menu.on("menu:complete", function () {
              $menuScroll = $menu.find(".menu-scroller");

              if (!loaded) {
                loaded = true;

                $menuScroll.find(".js-psEsSymbol").on("click", insertSymbol);

                editor.events.on("commands.mousedown", function ($el) {
                  if ($el.data("cmd") != "pfEsAddSymbol") {
                    handler.close();
                  }
                });

                $menu.on("menu:closed", function () {
                  scrollTop = $menuScroll.scrollTop();
                });
              }

              $menuScroll.scrollTop(scrollTop);
            });

            $menu.on("menu:closed", function () {
              setTimeout(function () {
                editor.markers.remove();
              }, 50);
            });
          }

          var clickHandlers = $btn.data("xfClickHandlers");
          if (clickHandlers && clickHandlers.menu) {
            clickHandlers.menu.toggle();
          }
        }

        function insertSymbol(e) {
          var $target = $(e.currentTarget),
            html = $target.html(),
            $html = $(html);

          XF.EditorHelpers.focus(editor);
          editor.html.insert(html);
          selectionSave();
          XF.EditorHelpers.blur(editor);
        }

        function selectionSave() {
          editor.selection.save();
        }

        function selectionRestore() {
          editor.selection.restore();
        }

        return {
          showMenu: showMenu,
        };
      };

      XF.EditorHelpers.dialogs.pfEditorSymbols = new XF.EditorDialogMedia(
        "pfEditorSymbols"
      );

      $.FE.DefineIcon("pfEsAddSymbol", { NAME: "university" });
      $.FE.RegisterCommand("pfEsAddSymbol", {
        title: "Insert Symbol",
        undo: true,
        focus: true,
        callback: function () {
          XF.EditorHelpers.loadDialog(this, "pfEditorSymbols");
        },
      });
    },
  };

  $(document).on("editor:start", PFES.editorButton.registerButtonCommands);
})(jQuery, window, document);
