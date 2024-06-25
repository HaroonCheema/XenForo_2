!function($, window, document, _undefined) {
    "use strict";
    $(document).ready(function() {
        themehouse.spotify.initialize();
    });
}(jQuery, window, document);

var themehouse = themehouse || {};

themehouse.spotify = {
    initialized: false,

    updateUserPlaybackTimeout: 3000,

    initialize: function() {
        if (!themehouse.spotify.initialized) {
            themehouse.spotify.initialized = true;

            setTimeout(themehouse.spotify.updateVisitorPlayback, 50);
        }
    },

    updateVisitorPlayback: function() {
        XF.ajax('GET',
            XF.canonicalizeUrl('index.php?spotify/update-current-playback'), {},
            function (data) {
                setTimeout(themehouse.spotify.updateVisitorPlayback, themehouse.spotify.updateUserPlaybackTimeout);
            }, {
                global: false,
                error: false
            }
        );
    }
};