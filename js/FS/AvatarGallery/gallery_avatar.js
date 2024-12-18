((window, document) => {
  "use strict";

  XF.XBgalleryavatar = XF.Event.newHandler({
    eventType: "click",
    eventNameSpace: "XBgalleryavatar",
    options: {
      contentSelector: null,
    },

    init() {},

    click(e) {
      e.preventDefault();

      const target = e.target;

      //   const parentElement = target.offsetParent;

      const parentDiv = target.parentElement;

      if (parentDiv.hasAttribute("data-avatar-data-path")) {
        const attributeValue = parentDiv.getAttribute("data-avatar-data-path");

        document.querySelector("#xb_avatar_choice").value = attributeValue;
      }

      var aiImgElement = document.querySelector("#ai_img");

      if (aiImgElement) {
        if (parentDiv.hasAttribute("data-ai-img")) {
          aiImgElement.value = "1";
        } else {
          aiImgElement.value = "";
        }
      }

      if (parentDiv.classList.contains("checked")) {
        document.querySelector("#xb_avatar_choice").value = "";
        document.querySelectorAll("div#xb_avatar_select").forEach((el) => {
          el.classList.remove("checked");
        });
      } else {
        document.querySelectorAll("div#xb_avatar_select").forEach((el) => {
          el.classList.remove("checked");
        });

        parentDiv.classList.add("checked");
      }
    },
  });

  XF.Event.register("click", "xb_avatar", "XF.XBgalleryavatar");
})(window, document);
