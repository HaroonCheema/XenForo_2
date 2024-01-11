!(function ($, window, document, _undefined) {
  "use strict";

  var socialPostType = "";

  XF.ShowUpgradeBox = XF.Click.newHandler({
    eventNameSpace: "ShowUpgradeBox",

    init: function () {},

    click: function (e) {
      e.preventDefault();

      var $targetUrl = $(e.currentTarget).data("validation-url");

      var $social_data = "test";
      //  $targetUrl =
      //    "http://localhost/xenforo/index.php?account-upgrade/purchase";
      XF.ajax("get", $targetUrl, $social_data, function (data) {
        if (data.html) {
          $("#purchase_bitcoin").empty();
          $("#purchase_bitcoin").append(data.html.content);
        }
      });
    },
  });

  XF.PostExport = XF.Click.newHandler({
    eventNameSpace: "XFPostExport",

    errorMessage_empty_box: "Image Url Required......",
    errorMessage_invalid_url:
      "Required Valid Post Image Url.Follow the instructions how to get Post Image url......",

    init: function () {},

    click: function (e) {
      e.preventDefault();
      var errorMessage_empty_box = this.errorMessage_empty_box;
      var errorMessage_invalid_url = this.errorMessage_invalid_url;

      var errorMessage_valid_url = this.errorMessage_valid_url;

      var imgsrc = $(".import_textbox_url").val();

      if (!imgsrc) {
        $("#response-error-message").text(errorMessage_empty_box).fadeIn();

        return;
      }

      switch (socialPostType) {
        case "facebook":
          if (
            imgsrc.indexOf("scontent") == -1 ||
            imgsrc.indexOf("https") == -1
          ) {
            $("#response-error-message")
              .text(errorMessage_invalid_url)
              .fadeIn();

            return;
          }
          this.performEmmbedImage(imgsrc);
          break;

        case "twitter":
          if (imgsrc.indexOf("twimg") == -1 || imgsrc.indexOf("https") == -1) {
            $("#response-error-message")
              .text(errorMessage_invalid_url)
              .fadeIn();

            return;
          }

          this.performEmmbedImage(imgsrc);
          break;

        case "instagram":
          if (imgsrc.indexOf("igcdn") == -1 || imgsrc.indexOf("https") == -1) {
            $("#response-error-message")
              .text(errorMessage_invalid_url)
              .fadeIn();

            return;
          }

          this.performInstragamImage(imgsrc);
          break;
      }
    },
    performInstragamImage: function (imgsrc) {
      var editor = XF.getEditorInContainer($("body"));
      XF.insertIntoEditor(
        $("body"),
        '<img src="' + imgsrc + '"style="width: auto;" />',
        "[IMG]" + imgsrc + "[/IMG]"
      );
      $("#social_post").empty();
    },
    performEmmbedImage: function (imgsrc) {
      var editor = XF.getEditorInContainer($("body"));
      XF.insertIntoEditor(
        $("body"),
        '<img src="' + imgsrc + '"style="width: auto;" />',
        "[IMG]" + imgsrc + "[/IMG]"
      );
      $("#social_post").empty();
    },
  });

  XF.ClosePostBox = XF.Click.newHandler({
    eventNameSpace: "XFClosePostBox",

    init: function () {},

    click: function (e) {
      e.preventDefault();

      $("#social_post").empty();
      $("#response-error-message").text("");
      $(".post_pop_box").hide();
      $(".import_textbox_url").val(null);
      socialPostType = "";
    },
  });

  XF.Click.register("show-upgrade-box", "XF.ShowUpgradeBox");
  XF.Click.register("close-post-box", "XF.ClosePostBox");
})(jQuery, window, document);
