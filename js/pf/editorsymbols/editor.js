var PFES = window.PFES || {};

!(function ($, window, document) {
  "use strict";

  // New Symbol Dialog
  PFES.EditorDialogSymbols = XF.extend(XF.EditorDialog, {
    _beforeShow: function (overlay) {
      this.ed.$el.blur();
    },

    _afterHide: function (overlay) {
      console.log("Symbol dialog hidden!");
    },

    _init: function (overlay) {
      var self = this;

      // Bind click handlers to symbol links
      overlay.$container.find(".js-psEsSymbol").on("click", function (e) {
        e.preventDefault();

        var $symbol = $(this),
          symbolValue = $symbol.data("value"); // e.g., '&fnof;'

        if (symbolValue) {
          var ed = self.ed,
            overlay = self.overlay;

          // Restore editor selection and insert symbol
          ed.selection.restore();
          ed.html.insert(symbolValue);

          // Hide the dialog
          overlay.hide();
        }
      });
    },
  });

  // Register symbol dialog
  XF.EditorHelpers.dialogs.pfEditorSymbols = new PFES.EditorDialogSymbols(
    "pfEditorSymbols"
  );

  // Froala command for symbol dialog
  $.FE.DefineIcon("pfEsAddSymbol", { NAME: "university" });
  $.FE.RegisterCommand("pfEsAddSymbol", {
    title: "Insert Symbol",
    undo: true,
    focus: true,
    callback: function () {
      XF.EditorHelpers.loadDialog(this, "pfEditorSymbols");
    },
  });
})(jQuery, window, document);
