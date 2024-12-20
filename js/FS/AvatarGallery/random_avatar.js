((window, document) => {
  "use strict";

  XF.fsRandomAvatar = XF.Event.newHandler({
    eventType: "click",
    eventNameSpace: "fsRandomAvatar",

    init() {},

    click(e) {
      e.preventDefault();

      const target = e.target;
      const parentDiv = target.parentElement;

      const limit = parentDiv.getAttribute("data-random-data-limit");

      const button = e.target;

      const hiddenInput = document.querySelector("#fs_random_avatar_limit");
      let currentValue = parseInt(hiddenInput.value || "0", 10);

      // console.log(`Current Value: ${currentValue}, Limit: ${limit}`);

      currentValue++;
      hiddenInput.value = currentValue;

      if (currentValue >= limit) {
        const randomButton = document.getElementById("random_button_c");
        if (randomButton) {
          randomButton.style.display = "none";
        }

        // return; // Stop further processing
      }

      XF.ajax(
        "POST",
        XF.canonicalizeUrl("index.php?register/random-avatar"),
        {},
        (data) => {
          if (data.randomImage) {
            const avatarImage = document.querySelector("#xb_avatar_select img");
            if (avatarImage) {
              avatarImage.src = data.randomImage.url;
            }

            const randomInput = document.querySelector("#fs_random_input");
            if (randomInput) {
              randomInput.value = data.randomImage["data-path"];
            }
          }
        },
        { skipDefaultSuccess: true }
      );
    },
  });

  XF.Event.register("click", "xb_random_avatar", "XF.fsRandomAvatar");
})(window, document);
