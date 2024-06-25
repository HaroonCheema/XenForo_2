!function ($, window, document, _undefined) {
    "use strict";

    XF.THHolidaysBats = XF.Element.newHandler({
        $options: null,

        init: function () {
            var options = {
                bats: 5
            };

            try {
                var configOptions = $.parseJSON($('.js-thHolidaysBatsOptions').first().html()) || {};
                for (let key in configOptions) {
                    options[key] = parseFloat(configOptions[key]);
                }
            }
            catch (e) {
                console.error(e);
            }

            this.$options = options;

            for (var i = 0; i < options.bats; i++) {
                this.initBat();
            }
        },

        initBat: function () {
            var n = 0,
                i = document.createElement('img'),
                z = document.createElement('div'),
                zs = z.style,
                a = window.innerWidth * Math.random(), b = window.innerHeight * Math.random();
            zs.position = "fixed";
            zs.left = 0;
            zs.top = 0;
            zs.opacity = 0;
            z.appendChild(i);
            i.src = 'data:image/gif;base64,R0lGODlhMAAwAJECAAAAAEJCQv///////yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQACACwAAAAAMAAwAAACdpSPqcvtD6NcYNpbr4Z5ewV0UvhRohOe5UE+6cq0carCgpzQuM3ut16zvRBAH+/XKQ6PvaQyCFs+mbnWlEq0FrGi15XZJSmxP8OTRj4DyWY1lKdmV8fyLL3eXOPn6D3f6BcoOEhYaHiImKi4yNjo+AgZKTl5WAAAIfkECQEAAgAsAAAAADAAMAAAAnyUj6nL7Q+jdCDWicF9G1vdeWICao05ciUVpkrZIqjLwCdI16s+5wfck+F8JOBiR/zZZAJk0mAsDp/KIHRKvVqb2KxTu/Vdvt/nGFs2V5Bpta3tBcKp8m5WWL/z5PpbtH/0B/iyNGh4iJiouMjY6PgIGSk5SVlpeYmZqVkAACH5BAkBAAIALAAAAAAwADAAAAJhlI+py+0Po5y02ouz3rz7D4biSJbmiabq6gCs4B5AvM7GTKv4buby7vsAbT9gZ4h0JYmZpXO4YEKeVCk0QkVUlw+uYovE8ibgaVBSLm1Pa3W194rL5/S6/Y7P6/f8vp9SAAAh+QQJAQACACwAAAAAMAAwAAACZZSPqcvtD6OctNqLs968+w+G4kiW5omm6ooALeCusAHHclyzQs3rOz9jAXuqIRFlPJ6SQWRSaIQOpUBqtfjEZpfMJqmrHIFtpbGze2ZywWu0aUwWEbfiZvQdD4sXuWUj7gPos1EAACH5BAkBAAIALAAAAAAwADAAAAJrlI+py+0Po5y02ouz3rz7D4ZiCIxUaU4Amjrr+rDg+7ojXTdyh+e7kPP0egjabGg0EIVImHLJa6KaUam1aqVynNNsUvPTQjO/J84cFA3RzlaJO2495TF63Y7P6/f8vv8PGCg4SFhoeIg4UQAAIfkEBQEAAgAsAAAAADAAMAAAAnaUj6nL7Q+jXGDaW6+GeXsFdFL4UaITnuVBPunKtHGqwoKc0LjN7rdes70QQB/v1ykOj72kMghbPpm51pRKtBaxoteV2SUpsT/Dk0Y+A8lmNZSnZlfH8iy93lzj5+g93+gXKDhIWGh4iJiouMjY6PgIGSk5eVgAADs=';
            $('.js-thHolidaysBatContainer').append(z);

            function random(o, m) {
                return Math.max(Math.min(o + (Math.random() - .5) * 400, m - 50), 50);
            }

            function animate() {
                var x = random(a, window.innerWidth), y = random(b, window.innerHeight),
                    d = 5 * Math.sqrt((a - x) * (a - x) + (b - y) * (b - y));
                zs.opacity = n;
                n = 1;
                zs.transition = zs.webkitTransition = d / 1000 + 's linear';
                zs.transform = zs.webkitTransform = 'translate(' + x + 'px,' + y + 'px)';
                i.style.transform = i.style.webkitTransform = (a > x) ? '' : 'scaleX(-1)';
                a = x;
                b = y;
                setTimeout(animate, d);
            }

            setTimeout(animate, Math.random() * 3000);
        }
    });

    XF.Element.register('th-holidays-bats', 'XF.THHolidaysBats');
}(jQuery, window, document);