!function ( $, window, document ) {
  "use strict";

  const setupEcho = () => {
    const buildOptions  = () => {
      let options = {
        namespace: '',
        broadcaster: 'pusher',
        key: XF.config.echo.key,
        forceTLS: false,
        encrypted: true,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
        csrfToken: XF.config.csrf,
        cluster: XF.config.echo.cluster,
        authEndpoint: XF.config.echo.authEndpoint,
        userAuthentication: {
          endpoint: XF.config.echo.userAuthEndpoint,
          headers: {
            'X-XF-Csrf-Token': XF.config.csrf
          }
        },
        auth: {
          headers: {
            'X-XF-Csrf-Token': XF.config.csrf
          }
        }
      }

      const isSoketi = !options.cluster
      if (isSoketi) {
        options = $.extend(options, {
          wsHost: XF.config.echo.host || window.location.host,
          wsPort: XF.config.echo.port,
          wssPort: XF.config.echo.port
        })
      }

      return options
    }

    XF.Echo = new Echo(buildOptions())

    XF.EchoManager = $.extend(XF.EchoManager || {}, {
      channels: {},

      init () {
        this.echo = XF.Echo

        this.joinDefaultChannels()
        this.addPageUidToAjaxHeaders()
        this.listenKeepAlive()

        $(document).trigger('websockets:connected', [this])
      },

      listenKeepAlive () {
        const url = XF.config.url.keepAlive;
        const crossTabEvent = 'keepAlive' + XF.stringHashCode(url);

        XF.CrossTab.on(crossTabEvent, () => {
          this.updateCsrfInConnector()
        })
      },

      updateCsrfInConnector () {
        const token = XF.config.csrf

        const updateOptions = options => {
          options.csrfToken = token

          options.userAuthentication.headers['X-CSRF-TOKEN'] = token
          options.auth.headers['X-CSRF-TOKEN'] = token

          options.userAuthentication.headers['X-XF-Csrf-Token'] = token
          options.auth.headers['X-XF-Csrf-Token'] = token
        }

        updateOptions(XF.Echo.connector.options)
        updateOptions(XF.Echo.options)
      },

      joinDefaultChannels () {
        this.channels['forum'] = this.echo.private('Forum')

        if (XF.config.userId) {
          this.channels['visitor'] = this.echo.private('User.' + XF.config.userId)
        }
      },

      addPageUidToAjaxHeaders () {
        $(document).on('ajax:send', ( e, xhr ) => {
          xhr.setRequestHeader('X-WebSockets-Page-Uid', XF.config.echo.pageUid)
        })
      },
    })

    XF.EchoManager.init()
  }

  window.getWebsocketsPromise = () => {
    return new Promise(( resolve, reject ) => {
      if (XF.Echo) {
        resolve({
          echo: XF.Echo,
          manager: XF.EchoManager
        })
      } else {
        $(document).on('websockets:connected', ( e, manager ) => {
          resolve({
            echo: manager.echo,
            manager: manager
          })
        })
      }
    })
  }

  const startCsrfCookie = XF.Cookie.get('csrf');
  let keepAliveTriggered = false;
  const getKeepAlivePromise = () => {
    return new Promise(( resolve, reject ) => {
      if (startCsrfCookie || keepAliveTriggered) {
        resolve({
          keepAlive: false
        })
        return;
      }

      const originalCrossTabTrigger = XF.CrossTab.trigger.bind(XF.CrossTab)

      const url = XF.config.url.keepAlive;
      const crossTabEvent = 'keepAlive' + XF.stringHashCode(url);

      // we can't use XF.CrossTab.on() because it's not triggered on the same tab
      // js/xf/core.js:4202
      XF.CrossTab.trigger = ( event, data, forceCall ) => {
        const result = originalCrossTabTrigger(event, data, forceCall)

        if (event === crossTabEvent) {
          setTimeout(() => {
            resolve({ keepAlive: true })
          }, 100)
        }

        keepAliveTriggered = true;

        return result
      }
    })
  }

  getKeepAlivePromise()
    .then(setupEcho)
}
(window.jQuery, window, document);
