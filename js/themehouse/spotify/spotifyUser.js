var themehouse = themehouse || {};

themehouse.spotifyUser = {
    initialized: false,
    user_id: 0,
    song_details: null,
    playback_details: null,
    songDuration: 1, // don't want to divide by 0
    songPosition: 0,
    lastPercent: '0%',
    lastProgress: '',
    playTimer: Date.now(),
    interval:  null,

    initialize: function(userId, songDetails, playbackDetails) {
        themehouse.spotifyUser.user_id = userId;
        themehouse.spotifyUser.song_details = songDetails;
        themehouse.spotifyUser.playback_details = playbackDetails;

        if (!themehouse.spotifyUser.initialized) {
            themehouse.spotifyUser.initialized = true;
            themehouse.spotifyUser.updateVisitorPlayback();
            themehouse.spotifyUser.interval = setInterval(themehouse.spotifyUser.progressVisitorPlayback, 100);
        }
    },

    progressVisitorPlayback: function() {
        if (!themehouse.spotifyUser.initialized) {
            return;
        }

        var currentPosition = themehouse.spotifyUser.getCurrentPosition();
        if (currentPosition >= themehouse.spotifyUser.songDuration) {
            return themehouse.spotifyUser.updateVisitorPlayback(true);
        }

        if ((Date.now() - themehouse.spotifyUser.playTimer) > 11000) {
            return themehouse.spotifyUser.killPlayer();
        }

        var newPercent = themehouse.spotifyUser.getProgressPercent();
        if (newPercent !== themehouse.spotifyUser.lastPercent) {
            $('.spotifyPlayback__trackDetails__progressBar__bar').css('width', newPercent);
            themehouse.spotifyUser.lastPercent = newPercent;
        }

        var newProgress = themehouse.spotifyUser.getProgressStr();
        if (newProgress !== themehouse.spotifyUser.lastProgress) {
            $('.spotifyPlayback__trackDetails__progress').html(newProgress);
            themehouse.spotifyUser.lastProgress = newProgress;
        }
    },

    updateVisitorPlayback: function(skipTimeout) {
        if (!themehouse.spotifyUser.initialized) {
            return;
        }
        XF.ajax('GET',
            XF.canonicalizeUrl('index.php?members/' + themehouse.spotifyUser.user_id + '/spotify-playback&raw=1'), {},
            function (response) {
                var data = response.data;
                if (data !== null) {
                    var song = data.song;
                    var playback = data.playback;

                    if (song.song_name !== themehouse.spotifyUser.song_details.song_name) {
                        $albumImage = $('.spotifyPlayback__albumArt img');
                        $albumImage.attr('src', song.album_thumbnail);
                        $albumImage.attr('alt', song.album_name);

                        $('.spotifyPlayback__trackDetails__title a').html(song.song_name).attr('href', song.song_url)
                        $('.spotifyPlayback__trackDetails__playButton a').attr('href', song.song_url);

                        $('.spotifyPlayback__trackDetails__album a').attr('href', song.album_url).html(song.album_name);
                        $('.spotifyPlayback__trackDetails__artists').html(song.artists);
                    }

                    $('.spotifyPlayback__trackDetails__progressBar__bar').css('width', themehouse.spotifyUser.getProgressPercent());
                    $('.spotifyPlayback__trackDetails__progress').html(themehouse.spotifyUser.getProgressStr());

                    themehouse.spotifyUser.song_details = song;
                    themehouse.spotifyUser.playback_details = playback;
                    themehouse.spotifyUser.songDuration = song.duration_ms;
                    themehouse.spotifyUser.songPosition = playback.progress_ms;
                    themehouse.spotifyUser.playTimer = Date.now();
                }

                if (skipTimeout !== true) {
                    setTimeout(themehouse.spotifyUser.updateVisitorPlayback, 5000);
                }
            }, {
                global: false
            }
        );
    },

    getProgressStr: function() {
        if (themehouse.spotifyUser.songDuration <= 1) {
            return '';
        }
        var currentPosition = themehouse.spotifyUser.getCurrentPosition();
        return themehouse.spotifyUser.makeTimeString(currentPosition) + ' / ' + themehouse.spotifyUser.makeTimeString(themehouse.spotifyUser.songDuration);
    },

    makeTimeString: function(timestampInMs) {
        var secondsRaw = Math.round(timestampInMs / 1000);
        var minutes = Math.floor(secondsRaw / 60) || 0;
        var seconds = secondsRaw - (minutes * 60);
        if (seconds < 10) {
            seconds = '0' + seconds.toString();
        }
        return minutes.toString() + ':' + seconds.toString();
    },

    getProgressPercent: function() {
        if (themehouse.spotifyUser.songDuration <= 1) {
            return '0%';
        }
        var currentPosition = themehouse.spotifyUser.getCurrentPosition();
        var newPercent = Math.round((currentPosition / themehouse.spotifyUser.songDuration) * 10000) / 100;
        if (newPercent > 100) {
            newPercent = 100;
        }
        newPercent = newPercent.toString() + '%';
        return newPercent;
    },

    getCurrentPosition: function() {
        var elapsedTime = Date.now() - themehouse.spotifyUser.playTimer;
        var currentPosition = themehouse.spotifyUser.songPosition + elapsedTime;
        if (currentPosition > themehouse.spotifyUser.songDuration) {
            currentPosition = themehouse.spotifyUser.songDuration;
        }
        return currentPosition;
    },

    killPlayer: function() {
        themehouse.spotifyUser.initialized = false;
        themehouse.spotifyUser.songDuration = 1;
        clearInterval(themehouse.spotifyUser.interval);
        $('.spotifyPlayback').css('display', 'none');
        $('.spotifyError').css('display', 'block');
    }
};
