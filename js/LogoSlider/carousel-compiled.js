!(function (t, e) {
  "object" == typeof exports && "undefined" != typeof module
    ? e(exports)
    : "function" == typeof define && define.amd
    ? define(["exports"], e)
    : e(
        ((t =
          "undefined" != typeof globalThis ? globalThis : t || self).window =
          t.window || {})
      );
})(this, function (t) {
  "use strict";
  const e = (t, e = 1e4) => (
      (t = parseFloat(t + "") || 0), Math.round((t + Number.EPSILON) * e) / e
    ),
    i = function (t, e = void 0) {
      return (
        !(!t || t === document.body || (e && t === e)) &&
        ((function (t) {
          if (!(t && t instanceof Element && t.offsetParent)) return !1;
          const e = t.scrollHeight > t.clientHeight,
            i = window.getComputedStyle(t).overflowY,
            n = -1 !== i.indexOf("hidden"),
            s = -1 !== i.indexOf("visible");
          return e && !n && !s;
        })(t)
          ? t
          : i(t.parentElement, e))
      );
    },
    n = function (t) {
      var e = new DOMParser().parseFromString(t, "text/html").body;
      if (e.childElementCount > 1) {
        for (var i = document.createElement("div"); e.firstChild; )
          i.appendChild(e.firstChild);
        return i;
      }
      return e.firstChild;
    },
    s = (t) => `${t || ""}`.split(" ").filter((t) => !!t),
    o = (t, e, i) => {
      t &&
        s(e).forEach((e) => {
          t.classList.toggle(e, i || !1);
        });
    };
  class a {
    constructor(t) {
      Object.defineProperty(this, "pageX", {
        enumerable: !0,
        configurable: !0,
        writable: !0,
        value: void 0,
      }),
        Object.defineProperty(this, "pageY", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "clientX", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "clientY", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "id", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "time", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "nativePointer", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        (this.nativePointer = t),
        (this.pageX = t.pageX),
        (this.pageY = t.pageY),
        (this.clientX = t.clientX),
        (this.clientY = t.clientY),
        (this.id = self.Touch && t instanceof Touch ? t.identifier : -1),
        (this.time = Date.now());
    }
  }
  const r = { passive: !1 };
  class l {
    constructor(
      t,
      { start: e = () => !0, move: i = () => {}, end: n = () => {} }
    ) {
      Object.defineProperty(this, "element", {
        enumerable: !0,
        configurable: !0,
        writable: !0,
        value: void 0,
      }),
        Object.defineProperty(this, "startCallback", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "moveCallback", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "endCallback", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "currentPointers", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: [],
        }),
        Object.defineProperty(this, "startPointers", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: [],
        }),
        (this.element = t),
        (this.startCallback = e),
        (this.moveCallback = i),
        (this.endCallback = n);
      for (const t of [
        "onPointerStart",
        "onTouchStart",
        "onMove",
        "onTouchEnd",
        "onPointerEnd",
        "onWindowBlur",
      ])
        this[t] = this[t].bind(this);
      this.element.addEventListener("mousedown", this.onPointerStart, r),
        this.element.addEventListener("touchstart", this.onTouchStart, r),
        this.element.addEventListener("touchmove", this.onMove, r),
        this.element.addEventListener("touchend", this.onTouchEnd),
        this.element.addEventListener("touchcancel", this.onTouchEnd);
    }
    onPointerStart(t) {
      if (!t.buttons || 0 !== t.button) return;
      const e = new a(t);
      this.currentPointers.some((t) => t.id === e.id) ||
        (this.triggerPointerStart(e, t) &&
          (window.addEventListener("mousemove", this.onMove),
          window.addEventListener("mouseup", this.onPointerEnd),
          window.addEventListener("blur", this.onWindowBlur)));
    }
    onTouchStart(t) {
      for (const e of Array.from(t.changedTouches || []))
        this.triggerPointerStart(new a(e), t);
      window.addEventListener("blur", this.onWindowBlur);
    }
    onMove(t) {
      const e = this.currentPointers.slice(),
        i =
          "changedTouches" in t
            ? Array.from(t.changedTouches || []).map((t) => new a(t))
            : [new a(t)],
        n = [];
      for (const t of i) {
        const e = this.currentPointers.findIndex((e) => e.id === t.id);
        e < 0 || (n.push(t), (this.currentPointers[e] = t));
      }
      n.length && this.moveCallback(t, this.currentPointers.slice(), e);
    }
    onPointerEnd(t) {
      (t.buttons > 0 && 0 !== t.button) ||
        (this.triggerPointerEnd(t, new a(t)),
        window.removeEventListener("mousemove", this.onMove),
        window.removeEventListener("mouseup", this.onPointerEnd),
        window.removeEventListener("blur", this.onWindowBlur));
    }
    onTouchEnd(t) {
      for (const e of Array.from(t.changedTouches || []))
        this.triggerPointerEnd(t, new a(e));
    }
    triggerPointerStart(t, e) {
      return (
        !!this.startCallback(e, t, this.currentPointers.slice()) &&
        (this.currentPointers.push(t), this.startPointers.push(t), !0)
      );
    }
    triggerPointerEnd(t, e) {
      const i = this.currentPointers.findIndex((t) => t.id === e.id);
      i < 0 ||
        (this.currentPointers.splice(i, 1),
        this.startPointers.splice(i, 1),
        this.endCallback(t, e, this.currentPointers.slice()));
    }
    onWindowBlur() {
      this.clear();
    }
    clear() {
      for (; this.currentPointers.length; ) {
        const t = this.currentPointers[this.currentPointers.length - 1];
        this.currentPointers.splice(this.currentPointers.length - 1, 1),
          this.startPointers.splice(this.currentPointers.length - 1, 1),
          this.endCallback(
            new Event("touchend", {
              bubbles: !0,
              cancelable: !0,
              clientX: t.clientX,
              clientY: t.clientY,
            }),
            t,
            this.currentPointers.slice()
          );
      }
    }
    stop() {
      this.element.removeEventListener("mousedown", this.onPointerStart, r),
        this.element.removeEventListener("touchstart", this.onTouchStart, r),
        this.element.removeEventListener("touchmove", this.onMove, r),
        this.element.removeEventListener("touchend", this.onTouchEnd),
        this.element.removeEventListener("touchcancel", this.onTouchEnd),
        window.removeEventListener("mousemove", this.onMove),
        window.removeEventListener("mouseup", this.onPointerEnd),
        window.removeEventListener("blur", this.onWindowBlur);
    }
  }
  function h(t, e) {
    return e
      ? Math.sqrt(
          Math.pow(e.clientX - t.clientX, 2) +
            Math.pow(e.clientY - t.clientY, 2)
        )
      : 0;
  }
  function c(t, e) {
    return e
      ? {
          clientX: (t.clientX + e.clientX) / 2,
          clientY: (t.clientY + e.clientY) / 2,
        }
      : t;
  }
  const d = (t) =>
      "object" == typeof t &&
      null !== t &&
      t.constructor === Object &&
      "[object Object]" === Object.prototype.toString.call(t),
    u = (t, ...e) => {
      const i = e.length;
      for (let n = 0; n < i; n++) {
        const i = e[n] || {};
        Object.entries(i).forEach(([e, i]) => {
          const n = Array.isArray(i) ? [] : {};
          t[e] || Object.assign(t, { [e]: n }),
            d(i)
              ? Object.assign(t[e], u(n, i))
              : Array.isArray(i)
              ? Object.assign(t, { [e]: [...i] })
              : Object.assign(t, { [e]: i });
        });
      }
      return t;
    },
    g = function (t, e) {
      return t
        .split(".")
        .reduce((t, e) => ("object" == typeof t ? t[e] : void 0), e);
    };
  class f {
    constructor(t = {}) {
      Object.defineProperty(this, "options", {
        enumerable: !0,
        configurable: !0,
        writable: !0,
        value: t,
      }),
        Object.defineProperty(this, "events", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: new Map(),
        }),
        this.setOptions(t);
      for (const t of Object.getOwnPropertyNames(Object.getPrototypeOf(this)))
        t.startsWith("on") &&
          "function" == typeof this[t] &&
          (this[t] = this[t].bind(this));
    }
    setOptions(t) {
      this.options = t ? u({}, this.constructor.defaults, t) : {};
      for (const [t, e] of Object.entries(this.option("on") || {}))
        this.on(t, e);
    }
    option(t, ...e) {
      let i = g(t, this.options);
      return i && "function" == typeof i && (i = i.call(this, this, ...e)), i;
    }
    optionFor(t, e, i, ...n) {
      let s = g(e, t);
      var o;
      "string" != typeof (o = s) ||
        isNaN(o) ||
        isNaN(parseFloat(o)) ||
        (s = parseFloat(s)),
        "true" === s && (s = !0),
        "false" === s && (s = !1),
        s && "function" == typeof s && (s = s.call(this, this, t, ...n));
      let a = g(e, this.options);
      return (
        a && "function" == typeof a
          ? (s = a.call(this, this, t, ...n, s))
          : void 0 === s && (s = a),
        void 0 === s ? i : s
      );
    }
    cn(t) {
      const e = this.options.classes;
      return (e && e[t]) || "";
    }
    localize(t, e = []) {
      t = String(t).replace(/\{\{(\w+).?(\w+)?\}\}/g, (t, e, i) => {
        let n = "";
        return (
          i
            ? (n = this.option(
                `${e[0] + e.toLowerCase().substring(1)}.l10n.${i}`
              ))
            : e && (n = this.option(`l10n.${e}`)),
          n || (n = t),
          n
        );
      });
      for (let i = 0; i < e.length; i++) t = t.split(e[i][0]).join(e[i][1]);
      return (t = t.replace(/\{\{(.*?)\}\}/g, (t, e) => e));
    }
    on(t, e) {
      let i = [];
      "string" == typeof t ? (i = t.split(" ")) : Array.isArray(t) && (i = t),
        this.events || (this.events = new Map()),
        i.forEach((t) => {
          let i = this.events.get(t);
          i || (this.events.set(t, []), (i = [])),
            i.includes(e) || i.push(e),
            this.events.set(t, i);
        });
    }
    off(t, e) {
      let i = [];
      "string" == typeof t ? (i = t.split(" ")) : Array.isArray(t) && (i = t),
        i.forEach((t) => {
          const i = this.events.get(t);
          if (Array.isArray(i)) {
            const t = i.indexOf(e);
            t > -1 && i.splice(t, 1);
          }
        });
    }
    emit(t, ...e) {
      [...(this.events.get(t) || [])].forEach((t) => t(this, ...e)),
        "*" !== t && this.emit("*", t, ...e);
    }
  }
  Object.defineProperty(f, "version", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: "5.0.36",
  }),
    Object.defineProperty(f, "defaults", {
      enumerable: !0,
      configurable: !0,
      writable: !0,
      value: {},
    });
  class p extends f {
    constructor(t = {}) {
      super(t),
        Object.defineProperty(this, "plugins", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: {},
        });
    }
    attachPlugins(t = {}) {
      const e = new Map();
      for (const [i, n] of Object.entries(t)) {
        const t = this.option(i),
          s = this.plugins[i];
        s || !1 === t
          ? s && !1 === t && (s.detach(), delete this.plugins[i])
          : e.set(i, new n(this, t || {}));
      }
      for (const [t, i] of e) (this.plugins[t] = i), i.attach();
    }
    detachPlugins(t) {
      t = t || Object.keys(this.plugins);
      for (const e of t) {
        const t = this.plugins[e];
        t && t.detach(), delete this.plugins[e];
      }
      return this.emit("detachPlugins"), this;
    }
  }
  var m;
  !(function (t) {
    (t[(t.Init = 0)] = "Init"),
      (t[(t.Error = 1)] = "Error"),
      (t[(t.Ready = 2)] = "Ready"),
      (t[(t.Panning = 3)] = "Panning"),
      (t[(t.Mousemove = 4)] = "Mousemove"),
      (t[(t.Destroy = 5)] = "Destroy");
  })(m || (m = {}));
  const b = ["a", "b", "c", "d", "e", "f"],
    v = {
      content: null,
      width: "auto",
      height: "auto",
      panMode: "drag",
      touch: !0,
      dragMinThreshold: 3,
      lockAxis: !1,
      mouseMoveFactor: 1,
      mouseMoveFriction: 0.12,
      zoom: !0,
      pinchToZoom: !0,
      panOnlyZoomed: "auto",
      minScale: 1,
      maxScale: 2,
      friction: 0.25,
      dragFriction: 0.35,
      decelFriction: 0.05,
      click: "toggleZoom",
      dblClick: !1,
      wheel: "zoom",
      wheelLimit: 7,
      spinner: !0,
      bounds: "auto",
      infinite: !1,
      rubberband: !0,
      bounce: !0,
      maxVelocity: 75,
      transformParent: !1,
      classes: {
        content: "f-panzoom__content",
        isLoading: "is-loading",
        canZoomIn: "can-zoom_in",
        canZoomOut: "can-zoom_out",
        isDraggable: "is-draggable",
        isDragging: "is-dragging",
        inFullscreen: "in-fullscreen",
        htmlHasFullscreen: "with-panzoom-in-fullscreen",
      },
      l10n: {
        PANUP: "Move up",
        PANDOWN: "Move down",
        PANLEFT: "Move left",
        PANRIGHT: "Move right",
        ZOOMIN: "Zoom in",
        ZOOMOUT: "Zoom out",
        TOGGLEZOOM: "Toggle zoom level",
        TOGGLE1TO1: "Toggle zoom level",
        ITERATEZOOM: "Toggle zoom level",
        ROTATECCW: "Rotate counterclockwise",
        ROTATECW: "Rotate clockwise",
        FLIPX: "Flip horizontally",
        FLIPY: "Flip vertically",
        FITX: "Fit horizontally",
        FITY: "Fit vertically",
        RESET: "Reset",
        TOGGLEFS: "Toggle fullscreen",
      },
    },
    y = '<circle cx="25" cy="25" r="20"></circle>',
    w =
      '<div class="f-spinner"><svg viewBox="0 0 50 50">' +
      y +
      y +
      "</svg></div>",
    x = (t) => t && null !== t && t instanceof Element && "nodeType" in t,
    P = (t, e) => {
      t &&
        s(e).forEach((e) => {
          t.classList.remove(e);
        });
    },
    T = (t, e) => {
      t &&
        s(e).forEach((e) => {
          t.classList.add(e);
        });
    },
    S = { a: 1, b: 0, c: 0, d: 1, e: 0, f: 0 },
    M = 1e5,
    O = 1e4,
    E = "mousemove",
    k = "drag",
    z = "content",
    L = "auto";
  let D = null,
    C = null;
  class R extends p {
    get fits() {
      return (
        this.contentRect.width - this.contentRect.fitWidth < 1 &&
        this.contentRect.height - this.contentRect.fitHeight < 1
      );
    }
    get isTouchDevice() {
      return null === C && (C = window.matchMedia("(hover: none)").matches), C;
    }
    get isMobile() {
      return (
        null === D &&
          (D = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent)),
        D
      );
    }
    get panMode() {
      return this.options.panMode !== E || this.isTouchDevice ? k : E;
    }
    get panOnlyZoomed() {
      const t = this.options.panOnlyZoomed;
      return t === L ? this.isTouchDevice : t;
    }
    get isInfinite() {
      return this.option("infinite");
    }
    get angle() {
      return (180 * Math.atan2(this.current.b, this.current.a)) / Math.PI || 0;
    }
    get targetAngle() {
      return (180 * Math.atan2(this.target.b, this.target.a)) / Math.PI || 0;
    }
    get scale() {
      const { a: t, b: e } = this.current;
      return Math.sqrt(t * t + e * e) || 1;
    }
    get targetScale() {
      const { a: t, b: e } = this.target;
      return Math.sqrt(t * t + e * e) || 1;
    }
    get minScale() {
      return this.option("minScale") || 1;
    }
    get fullScale() {
      const { contentRect: t } = this;
      return t.fullWidth / t.fitWidth || 1;
    }
    get maxScale() {
      return this.fullScale * (this.option("maxScale") || 1) || 1;
    }
    get coverScale() {
      const { containerRect: t, contentRect: e } = this,
        i = Math.max(t.height / e.fitHeight, t.width / e.fitWidth) || 1;
      return Math.min(this.fullScale, i);
    }
    get isScaling() {
      return Math.abs(this.targetScale - this.scale) > 1e-5 && !this.isResting;
    }
    get isContentLoading() {
      const t = this.content;
      return !!(t && t instanceof HTMLImageElement) && !t.complete;
    }
    get isResting() {
      if (this.isBouncingX || this.isBouncingY) return !1;
      for (const t of b) {
        const e = "e" == t || "f" === t ? 1e-4 : 1e-5;
        if (Math.abs(this.target[t] - this.current[t]) > e) return !1;
      }
      return !(!this.ignoreBounds && !this.checkBounds().inBounds);
    }
    constructor(t, e = {}, i = {}) {
      var s;
      if (
        (super(e),
        Object.defineProperty(this, "pointerTracker", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "resizeObserver", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "updateTimer", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "clickTimer", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "rAF", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "isTicking", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "ignoreBounds", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "isBouncingX", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "isBouncingY", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "clicks", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "trackingPoints", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: [],
        }),
        Object.defineProperty(this, "pwt", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "cwd", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "pmme", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "friction", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "state", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: m.Init,
        }),
        Object.defineProperty(this, "isDragging", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "container", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "content", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "spinner", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "containerRect", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: { width: 0, height: 0, innerWidth: 0, innerHeight: 0 },
        }),
        Object.defineProperty(this, "contentRect", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0,
            fullWidth: 0,
            fullHeight: 0,
            fitWidth: 0,
            fitHeight: 0,
            width: 0,
            height: 0,
          },
        }),
        Object.defineProperty(this, "dragStart", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: { x: 0, y: 0, top: 0, left: 0, time: 0 },
        }),
        Object.defineProperty(this, "dragOffset", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: { x: 0, y: 0, time: 0 },
        }),
        Object.defineProperty(this, "current", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: Object.assign({}, S),
        }),
        Object.defineProperty(this, "target", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: Object.assign({}, S),
        }),
        Object.defineProperty(this, "velocity", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: { a: 0, b: 0, c: 0, d: 0, e: 0, f: 0 },
        }),
        Object.defineProperty(this, "lockedAxis", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        !t)
      )
        throw new Error("Container Element Not Found");
      (this.container = t),
        this.initContent(),
        this.attachPlugins(Object.assign(Object.assign({}, R.Plugins), i)),
        this.emit("attachPlugins"),
        this.emit("init");
      const o = this.content;
      if (
        (o.addEventListener("load", this.onLoad),
        o.addEventListener("error", this.onError),
        this.isContentLoading)
      ) {
        if (this.option("spinner")) {
          t.classList.add(this.cn("isLoading"));
          const e = n(w);
          !t.contains(o) || o.parentElement instanceof HTMLPictureElement
            ? (this.spinner = t.appendChild(e))
            : (this.spinner =
                (null === (s = o.parentElement) || void 0 === s
                  ? void 0
                  : s.insertBefore(e, o)) || null);
        }
        this.emit("beforeLoad");
      } else
        queueMicrotask(() => {
          this.enable();
        });
    }
    initContent() {
      const { container: t } = this,
        e = this.cn(z);
      let i = this.option(z) || t.querySelector(`.${e}`);
      if (
        (i ||
          ((i = t.querySelector("img,picture") || t.firstElementChild),
          i && T(i, e)),
        i instanceof HTMLPictureElement && (i = i.querySelector("img")),
        !i)
      )
        throw new Error("No content found");
      this.content = i;
    }
    onLoad() {
      const { spinner: t, container: e, state: i } = this;
      t && (t.remove(), (this.spinner = null)),
        this.option("spinner") && e.classList.remove(this.cn("isLoading")),
        this.emit("afterLoad"),
        i === m.Init ? this.enable() : this.updateMetrics();
    }
    onError() {
      this.state !== m.Destroy &&
        (this.spinner && (this.spinner.remove(), (this.spinner = null)),
        this.stop(),
        this.detachEvents(),
        (this.state = m.Error),
        this.emit("error"));
    }
    getNextScale(t) {
      const {
        fullScale: e,
        targetScale: i,
        coverScale: n,
        maxScale: s,
        minScale: o,
      } = this;
      let a = o;
      switch (t) {
        case "toggleMax":
          a = i - o < 0.5 * (s - o) ? s : o;
          break;
        case "toggleCover":
          a = i - o < 0.5 * (n - o) ? n : o;
          break;
        case "toggleZoom":
          a = i - o < 0.5 * (e - o) ? e : o;
          break;
        case "iterateZoom":
          let t = [1, e, s].sort((t, e) => t - e),
            r = t.findIndex((t) => t > i + 1e-5);
          a = t[r] || 1;
      }
      return a;
    }
    attachObserver() {
      var t;
      const e = () => {
        const { container: t, containerRect: e } = this;
        return (
          Math.abs(e.width - t.getBoundingClientRect().width) > 0.1 ||
          Math.abs(e.height - t.getBoundingClientRect().height) > 0.1
        );
      };
      this.resizeObserver ||
        void 0 === window.ResizeObserver ||
        (this.resizeObserver = new ResizeObserver(() => {
          this.updateTimer ||
            (e()
              ? (this.onResize(),
                this.isMobile &&
                  (this.updateTimer = setTimeout(() => {
                    e() && this.onResize(), (this.updateTimer = null);
                  }, 500)))
              : this.updateTimer &&
                (clearTimeout(this.updateTimer), (this.updateTimer = null)));
        })),
        null === (t = this.resizeObserver) ||
          void 0 === t ||
          t.observe(this.container);
    }
    detachObserver() {
      var t;
      null === (t = this.resizeObserver) || void 0 === t || t.disconnect();
    }
    attachEvents() {
      const { container: t } = this;
      t.addEventListener("click", this.onClick, { passive: !1, capture: !1 }),
        t.addEventListener("wheel", this.onWheel, { passive: !1 }),
        (this.pointerTracker = new l(t, {
          start: this.onPointerDown,
          move: this.onPointerMove,
          end: this.onPointerUp,
        })),
        document.addEventListener(E, this.onMouseMove);
    }
    detachEvents() {
      var t;
      const { container: e } = this;
      e.removeEventListener("click", this.onClick, {
        passive: !1,
        capture: !1,
      }),
        e.removeEventListener("wheel", this.onWheel, { passive: !1 }),
        null === (t = this.pointerTracker) || void 0 === t || t.stop(),
        (this.pointerTracker = null),
        document.removeEventListener(E, this.onMouseMove),
        document.removeEventListener("keydown", this.onKeydown, !0),
        this.clickTimer &&
          (clearTimeout(this.clickTimer), (this.clickTimer = null)),
        this.updateTimer &&
          (clearTimeout(this.updateTimer), (this.updateTimer = null));
    }
    animate() {
      this.setTargetForce();
      const t = this.friction,
        e = this.option("maxVelocity");
      for (const i of b)
        t
          ? ((this.velocity[i] *= 1 - t),
            e &&
              !this.isScaling &&
              (this.velocity[i] = Math.max(
                Math.min(this.velocity[i], e),
                -1 * e
              )),
            (this.current[i] += this.velocity[i]))
          : (this.current[i] = this.target[i]);
      this.setTransform(),
        this.setEdgeForce(),
        !this.isResting || this.isDragging
          ? (this.rAF = requestAnimationFrame(() => this.animate()))
          : this.stop("current");
    }
    setTargetForce() {
      for (const t of b)
        ("e" === t && this.isBouncingX) ||
          ("f" === t && this.isBouncingY) ||
          (this.velocity[t] =
            (1 / (1 - this.friction) - 1) * (this.target[t] - this.current[t]));
    }
    checkBounds(t = 0, e = 0) {
      const { current: i } = this,
        n = i.e + t,
        s = i.f + e,
        o = this.getBounds(),
        { x: a, y: r } = o,
        l = a.min,
        h = a.max,
        c = r.min,
        d = r.max;
      let u = 0,
        g = 0;
      return (
        l !== 1 / 0 && n < l
          ? (u = l - n)
          : h !== 1 / 0 && n > h && (u = h - n),
        c !== 1 / 0 && s < c
          ? (g = c - s)
          : d !== 1 / 0 && s > d && (g = d - s),
        Math.abs(u) < 1e-4 && (u = 0),
        Math.abs(g) < 1e-4 && (g = 0),
        Object.assign(Object.assign({}, o), {
          xDiff: u,
          yDiff: g,
          inBounds: !u && !g,
        })
      );
    }
    clampTargetBounds() {
      const { target: t } = this,
        { x: e, y: i } = this.getBounds();
      e.min !== 1 / 0 && (t.e = Math.max(t.e, e.min)),
        e.max !== 1 / 0 && (t.e = Math.min(t.e, e.max)),
        i.min !== 1 / 0 && (t.f = Math.max(t.f, i.min)),
        i.max !== 1 / 0 && (t.f = Math.min(t.f, i.max));
    }
    calculateContentDim(t = this.current) {
      const { content: e, contentRect: i } = this,
        { fitWidth: n, fitHeight: s, fullWidth: o, fullHeight: a } = i;
      let r = o,
        l = a;
      if (this.option("zoom") || 0 !== this.angle) {
        const i =
            !(e instanceof HTMLImageElement) &&
            ("none" === window.getComputedStyle(e).maxWidth ||
              "none" === window.getComputedStyle(e).maxHeight),
          h = i ? o : n,
          c = i ? a : s,
          d = this.getMatrix(t),
          u = new DOMPoint(0, 0).matrixTransform(d),
          g = new DOMPoint(0 + h, 0).matrixTransform(d),
          f = new DOMPoint(0 + h, 0 + c).matrixTransform(d),
          p = new DOMPoint(0, 0 + c).matrixTransform(d),
          m = Math.abs(f.x - u.x),
          b = Math.abs(f.y - u.y),
          v = Math.abs(p.x - g.x),
          y = Math.abs(p.y - g.y);
        (r = Math.max(m, v)), (l = Math.max(b, y));
      }
      return { contentWidth: r, contentHeight: l };
    }
    setEdgeForce() {
      if (
        this.ignoreBounds ||
        this.isDragging ||
        this.panMode === E ||
        this.targetScale < this.scale
      )
        return (this.isBouncingX = !1), void (this.isBouncingY = !1);
      const { target: t } = this,
        { x: e, y: i, xDiff: n, yDiff: s } = this.checkBounds();
      const o = this.option("maxVelocity");
      let a = this.velocity.e,
        r = this.velocity.f;
      0 !== n
        ? ((this.isBouncingX = !0),
          n * a <= 0
            ? (a += 0.14 * n)
            : ((a = 0.14 * n),
              e.min !== 1 / 0 && (this.target.e = Math.max(t.e, e.min)),
              e.max !== 1 / 0 && (this.target.e = Math.min(t.e, e.max))),
          o && (a = Math.max(Math.min(a, o), -1 * o)))
        : (this.isBouncingX = !1),
        0 !== s
          ? ((this.isBouncingY = !0),
            s * r <= 0
              ? (r += 0.14 * s)
              : ((r = 0.14 * s),
                i.min !== 1 / 0 && (this.target.f = Math.max(t.f, i.min)),
                i.max !== 1 / 0 && (this.target.f = Math.min(t.f, i.max))),
            o && (r = Math.max(Math.min(r, o), -1 * o)))
          : (this.isBouncingY = !1),
        this.isBouncingX && (this.velocity.e = a),
        this.isBouncingY && (this.velocity.f = r);
    }
    enable() {
      const { content: t } = this,
        e = new DOMMatrixReadOnly(window.getComputedStyle(t).transform);
      for (const t of b) this.current[t] = this.target[t] = e[t];
      this.updateMetrics(),
        this.attachObserver(),
        this.attachEvents(),
        (this.state = m.Ready),
        this.emit("ready");
    }
    onClick(t) {
      var e;
      "click" === t.type &&
        0 === t.detail &&
        ((this.dragOffset.x = 0), (this.dragOffset.y = 0)),
        this.isDragging &&
          (null === (e = this.pointerTracker) || void 0 === e || e.clear(),
          (this.trackingPoints = []),
          this.startDecelAnim());
      const i = t.target;
      if (!i || t.defaultPrevented) return;
      if (i.hasAttribute("disabled"))
        return t.preventDefault(), void t.stopPropagation();
      if (
        (() => {
          const t = window.getSelection();
          return t && "Range" === t.type;
        })() &&
        !i.closest("button")
      )
        return;
      const n = i.closest("[data-panzoom-action]"),
        s = i.closest("[data-panzoom-change]"),
        o = n || s,
        a = o && x(o) ? o.dataset : null;
      if (a) {
        const e = a.panzoomChange,
          i = a.panzoomAction;
        if (((e || i) && t.preventDefault(), e)) {
          let t = {};
          try {
            t = JSON.parse(e);
          } catch (t) {
            console && console.warn("The given data was not valid JSON");
          }
          return void this.applyChange(t);
        }
        if (i) return void (this[i] && this[i]());
      }
      if (Math.abs(this.dragOffset.x) > 3 || Math.abs(this.dragOffset.y) > 3)
        return t.preventDefault(), void t.stopPropagation();
      if (i.closest("[data-fancybox]")) return;
      const r = this.content.getBoundingClientRect(),
        l = this.dragStart;
      if (
        l.time &&
        !this.canZoomOut() &&
        (Math.abs(r.x - l.x) > 2 || Math.abs(r.y - l.y) > 2)
      )
        return;
      this.dragStart.time = 0;
      const h = (e) => {
          this.option("zoom", t) &&
            e &&
            "string" == typeof e &&
            /(iterateZoom)|(toggle(Zoom|Full|Cover|Max)|(zoomTo(Fit|Cover|Max)))/.test(
              e
            ) &&
            "function" == typeof this[e] &&
            (t.preventDefault(), this[e]({ event: t }));
        },
        c = this.option("click", t),
        d = this.option("dblClick", t);
      d
        ? (this.clicks++,
          1 == this.clicks &&
            (this.clickTimer = setTimeout(() => {
              1 === this.clicks
                ? (this.emit("click", t), !t.defaultPrevented && c && h(c))
                : (this.emit("dblClick", t), t.defaultPrevented || h(d)),
                (this.clicks = 0),
                (this.clickTimer = null);
            }, 350)))
        : (this.emit("click", t), !t.defaultPrevented && c && h(c));
    }
    addTrackingPoint(t) {
      const e = this.trackingPoints.filter((t) => t.time > Date.now() - 100);
      e.push(t), (this.trackingPoints = e);
    }
    onPointerDown(t, e, i) {
      var n;
      if (!1 === this.option("touch", t)) return !1;
      (this.pwt = 0),
        (this.dragOffset = { x: 0, y: 0, time: 0 }),
        (this.trackingPoints = []);
      const s = this.content.getBoundingClientRect();
      if (
        ((this.dragStart = {
          x: s.x,
          y: s.y,
          top: s.top,
          left: s.left,
          time: Date.now(),
        }),
        this.clickTimer)
      )
        return !1;
      if (this.panMode === E && this.targetScale > 1)
        return t.preventDefault(), t.stopPropagation(), !1;
      const o = t.composedPath()[0];
      if (!i.length) {
        if (
          ["TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO", "IFRAME"].includes(
            o.nodeName
          ) ||
          o.closest(
            "[contenteditable],[data-selectable],[data-draggable],[data-clickable],[data-panzoom-change],[data-panzoom-action]"
          )
        )
          return !1;
        null === (n = window.getSelection()) ||
          void 0 === n ||
          n.removeAllRanges();
      }
      if ("mousedown" === t.type)
        ["A", "BUTTON"].includes(o.nodeName) || t.preventDefault();
      else if (Math.abs(this.velocity.a) > 0.3) return !1;
      return (
        (this.target.e = this.current.e),
        (this.target.f = this.current.f),
        this.stop(),
        this.isDragging ||
          ((this.isDragging = !0),
          this.addTrackingPoint(e),
          this.emit("touchStart", t)),
        !0
      );
    }
    onPointerMove(t, n, s) {
      if (!1 === this.option("touch", t)) return;
      if (!this.isDragging) return;
      if (
        n.length < 2 &&
        this.panOnlyZoomed &&
        e(this.targetScale) <= e(this.minScale)
      )
        return;
      if ((this.emit("touchMove", t), t.defaultPrevented)) return;
      this.addTrackingPoint(n[0]);
      const { content: o } = this,
        a = c(s[0], s[1]),
        r = c(n[0], n[1]);
      let l = 0,
        d = 0;
      if (n.length > 1) {
        const t = o.getBoundingClientRect();
        (l = a.clientX - t.left - 0.5 * t.width),
          (d = a.clientY - t.top - 0.5 * t.height);
      }
      const u = h(s[0], s[1]),
        g = h(n[0], n[1]);
      let f = u ? g / u : 1,
        p = r.clientX - a.clientX,
        m = r.clientY - a.clientY;
      (this.dragOffset.x += p),
        (this.dragOffset.y += m),
        (this.dragOffset.time = Date.now() - this.dragStart.time);
      let b =
        e(this.targetScale) === e(this.minScale) && this.option("lockAxis");
      if (b && !this.lockedAxis)
        if ("xy" === b || "y" === b || "touchmove" === t.type) {
          if (
            Math.abs(this.dragOffset.x) < 6 &&
            Math.abs(this.dragOffset.y) < 6
          )
            return void t.preventDefault();
          const e = Math.abs(
            (180 * Math.atan2(this.dragOffset.y, this.dragOffset.x)) / Math.PI
          );
          (this.lockedAxis = e > 45 && e < 135 ? "y" : "x"),
            (this.dragOffset.x = 0),
            (this.dragOffset.y = 0),
            (p = 0),
            (m = 0);
        } else this.lockedAxis = b;
      if (
        (i(t.target, this.content) && ((b = "x"), (this.dragOffset.y = 0)),
        b &&
          "xy" !== b &&
          this.lockedAxis !== b &&
          e(this.targetScale) === e(this.minScale))
      )
        return;
      t.cancelable && t.preventDefault(),
        this.container.classList.add(this.cn("isDragging"));
      const v = this.checkBounds(p, m);
      this.option("rubberband")
        ? ("x" !== this.isInfinite &&
            ((v.xDiff > 0 && p < 0) || (v.xDiff < 0 && p > 0)) &&
            (p *= Math.max(
              0,
              0.5 - Math.abs((0.75 / this.contentRect.fitWidth) * v.xDiff)
            )),
          "y" !== this.isInfinite &&
            ((v.yDiff > 0 && m < 0) || (v.yDiff < 0 && m > 0)) &&
            (m *= Math.max(
              0,
              0.5 - Math.abs((0.75 / this.contentRect.fitHeight) * v.yDiff)
            )))
        : (v.xDiff && (p = 0), v.yDiff && (m = 0));
      const y = this.targetScale,
        w = this.minScale,
        x = this.maxScale;
      y < 0.5 * w && (f = Math.max(f, w)),
        y > 1.5 * x && (f = Math.min(f, x)),
        "y" === this.lockedAxis && e(y) === e(w) && (p = 0),
        "x" === this.lockedAxis && e(y) === e(w) && (m = 0),
        this.applyChange({
          originX: l,
          originY: d,
          panX: p,
          panY: m,
          scale: f,
          friction: this.option("dragFriction"),
          ignoreBounds: !0,
        });
    }
    onPointerUp(t, e, n) {
      if (n.length)
        return (
          (this.dragOffset.x = 0),
          (this.dragOffset.y = 0),
          void (this.trackingPoints = [])
        );
      this.container.classList.remove(this.cn("isDragging")),
        this.isDragging &&
          (this.addTrackingPoint(e),
          this.panOnlyZoomed &&
            this.contentRect.width - this.contentRect.fitWidth < 1 &&
            this.contentRect.height - this.contentRect.fitHeight < 1 &&
            (this.trackingPoints = []),
          i(t.target, this.content) &&
            "y" === this.lockedAxis &&
            (this.trackingPoints = []),
          this.emit("touchEnd", t),
          (this.isDragging = !1),
          (this.lockedAxis = !1),
          this.state !== m.Destroy &&
            (t.defaultPrevented || this.startDecelAnim()));
    }
    startDecelAnim() {
      var t;
      const i = this.isScaling;
      this.rAF && (cancelAnimationFrame(this.rAF), (this.rAF = null)),
        (this.isBouncingX = !1),
        (this.isBouncingY = !1);
      for (const t of b) this.velocity[t] = 0;
      (this.target.e = this.current.e),
        (this.target.f = this.current.f),
        P(this.container, "is-scaling"),
        P(this.container, "is-animating"),
        (this.isTicking = !1);
      const { trackingPoints: n } = this,
        s = n[0],
        o = n[n.length - 1];
      let a = 0,
        r = 0,
        l = 0;
      o &&
        s &&
        ((a = o.clientX - s.clientX),
        (r = o.clientY - s.clientY),
        (l = o.time - s.time));
      const h =
        (null === (t = window.visualViewport) || void 0 === t
          ? void 0
          : t.scale) || 1;
      1 !== h && ((a *= h), (r *= h));
      let c = 0,
        d = 0,
        u = 0,
        g = 0,
        f = this.option("decelFriction");
      const p = this.targetScale;
      if (l > 0) {
        (u = Math.abs(a) > 3 ? a / (l / 30) : 0),
          (g = Math.abs(r) > 3 ? r / (l / 30) : 0);
        const t = this.option("maxVelocity");
        t &&
          ((u = Math.max(Math.min(u, t), -1 * t)),
          (g = Math.max(Math.min(g, t), -1 * t)));
      }
      u && (c = u / (1 / (1 - f) - 1)),
        g && (d = g / (1 / (1 - f) - 1)),
        ("y" === this.option("lockAxis") ||
          ("xy" === this.option("lockAxis") &&
            "y" === this.lockedAxis &&
            e(p) === this.minScale)) &&
          (c = u = 0),
        ("x" === this.option("lockAxis") ||
          ("xy" === this.option("lockAxis") &&
            "x" === this.lockedAxis &&
            e(p) === this.minScale)) &&
          (d = g = 0);
      const m = this.dragOffset.x,
        v = this.dragOffset.y,
        y = this.option("dragMinThreshold") || 0;
      Math.abs(m) < y && Math.abs(v) < y && ((c = d = 0), (u = g = 0)),
        ((this.option("zoom") &&
          (p < this.minScale - 1e-5 || p > this.maxScale + 1e-5)) ||
          (i && !c && !d)) &&
          (f = 0.35),
        this.applyChange({ panX: c, panY: d, friction: f }),
        this.emit("decel", u, g, m, v);
    }
    onWheel(t) {
      var e = [-t.deltaX || 0, -t.deltaY || 0, -t.detail || 0].reduce(function (
        t,
        e
      ) {
        return Math.abs(e) > Math.abs(t) ? e : t;
      });
      const i = Math.max(-1, Math.min(1, e));
      if ((this.emit("wheel", t, i), this.panMode === E)) return;
      if (t.defaultPrevented) return;
      const n = this.option("wheel");
      "pan" === n
        ? (t.preventDefault(),
          (this.panOnlyZoomed && !this.canZoomOut()) ||
            this.applyChange({
              panX: 2 * -t.deltaX,
              panY: 2 * -t.deltaY,
              bounce: !1,
            }))
        : "zoom" === n && !1 !== this.option("zoom") && this.zoomWithWheel(t);
    }
    onMouseMove(t) {
      this.panWithMouse(t);
    }
    onKeydown(t) {
      "Escape" === t.key && this.toggleFS();
    }
    onResize() {
      this.updateMetrics(), this.checkBounds().inBounds || this.requestTick();
    }
    setTransform() {
      this.emit("beforeTransform");
      const { current: t, target: i, content: n, contentRect: s } = this,
        o = Object.assign({}, S);
      for (const n of b) {
        const s = "e" == n || "f" === n ? O : M;
        (o[n] = e(t[n], s)),
          Math.abs(i[n] - t[n]) < ("e" == n || "f" === n ? 0.51 : 0.001) &&
            (t[n] = i[n]);
      }
      let { a: a, b: r, c: l, d: h, e: c, f: d } = o,
        u = `matrix(${a}, ${r}, ${l}, ${h}, ${c}, ${d})`,
        g = n.parentElement instanceof HTMLPictureElement ? n.parentElement : n;
      if (
        (this.option("transformParent") && (g = g.parentElement || g),
        g.style.transform === u)
      )
        return;
      g.style.transform = u;
      const { contentWidth: f, contentHeight: p } = this.calculateContentDim();
      (s.width = f), (s.height = p), this.emit("afterTransform");
    }
    updateMetrics(t = !1) {
      var i;
      if (!this || this.state === m.Destroy) return;
      if (this.isContentLoading) return;
      const n = Math.max(
          1,
          (null === (i = window.visualViewport) || void 0 === i
            ? void 0
            : i.scale) || 1
        ),
        { container: s, content: o } = this,
        a = o instanceof HTMLImageElement,
        r = s.getBoundingClientRect(),
        l = getComputedStyle(this.container);
      let h = r.width * n,
        c = r.height * n;
      const d = parseFloat(l.paddingTop) + parseFloat(l.paddingBottom),
        u = h - (parseFloat(l.paddingLeft) + parseFloat(l.paddingRight)),
        g = c - d;
      this.containerRect = {
        width: h,
        height: c,
        innerWidth: u,
        innerHeight: g,
      };
      const f =
          parseFloat(o.dataset.width || "") ||
          ((t) => {
            let e = 0;
            return (
              (e =
                t instanceof HTMLImageElement
                  ? t.naturalWidth
                  : t instanceof SVGElement
                  ? t.width.baseVal.value
                  : Math.max(t.offsetWidth, t.scrollWidth)),
              e || 0
            );
          })(o),
        p =
          parseFloat(o.dataset.height || "") ||
          ((t) => {
            let e = 0;
            return (
              (e =
                t instanceof HTMLImageElement
                  ? t.naturalHeight
                  : t instanceof SVGElement
                  ? t.height.baseVal.value
                  : Math.max(t.offsetHeight, t.scrollHeight)),
              e || 0
            );
          })(o);
      let b = this.option("width", f) || L,
        v = this.option("height", p) || L;
      const y = b === L,
        w = v === L;
      "number" != typeof b && (b = f),
        "number" != typeof v && (v = p),
        y && (b = f * (v / p)),
        w && (v = p / (f / b));
      let x =
        o.parentElement instanceof HTMLPictureElement ? o.parentElement : o;
      this.option("transformParent") && (x = x.parentElement || x);
      const P = x.getAttribute("style") || "";
      x.style.setProperty("transform", "none", "important"),
        a && ((x.style.width = ""), (x.style.height = "")),
        x.offsetHeight;
      const T = o.getBoundingClientRect();
      let S = T.width * n,
        M = T.height * n,
        O = S,
        E = M;
      (S = Math.min(S, b)),
        (M = Math.min(M, v)),
        a
          ? ({ width: S, height: M } = ((t, e, i, n) => {
              const s = i / t,
                o = n / e,
                a = Math.min(s, o);
              return { width: (t *= a), height: (e *= a) };
            })(b, v, S, M))
          : ((S = Math.min(S, b)), (M = Math.min(M, v)));
      let k = 0.5 * (E - M),
        z = 0.5 * (O - S);
      (this.contentRect = Object.assign(Object.assign({}, this.contentRect), {
        top: T.top - r.top + k,
        bottom: r.bottom - T.bottom + k,
        left: T.left - r.left + z,
        right: r.right - T.right + z,
        fitWidth: S,
        fitHeight: M,
        width: S,
        height: M,
        fullWidth: b,
        fullHeight: v,
      })),
        (x.style.cssText = P),
        a && ((x.style.width = `${S}px`), (x.style.height = `${M}px`)),
        this.setTransform(),
        !0 !== t && this.emit("refresh"),
        this.ignoreBounds ||
          (e(this.targetScale) < e(this.minScale)
            ? this.zoomTo(this.minScale, { friction: 0 })
            : this.targetScale > this.maxScale
            ? this.zoomTo(this.maxScale, { friction: 0 })
            : this.state === m.Init ||
              this.checkBounds().inBounds ||
              this.requestTick()),
        this.updateControls();
    }
    calculateBounds() {
      const { contentWidth: t, contentHeight: i } = this.calculateContentDim(
          this.target
        ),
        { targetScale: n, lockedAxis: s } = this,
        { fitWidth: o, fitHeight: a } = this.contentRect;
      let r = 0,
        l = 0,
        h = 0,
        c = 0;
      const d = this.option("infinite");
      if (!0 === d || (s && d === s))
        (r = -1 / 0), (h = 1 / 0), (l = -1 / 0), (c = 1 / 0);
      else {
        let { containerRect: s, contentRect: d } = this,
          u = e(o * n, O),
          g = e(a * n, O),
          { innerWidth: f, innerHeight: p } = s;
        if (
          (s.width === u && (f = s.width),
          s.width === g && (p = s.height),
          t > f)
        ) {
          (h = 0.5 * (t - f)), (r = -1 * h);
          let e = 0.5 * (d.right - d.left);
          (r += e), (h += e);
        }
        if (
          (o > f && t < f && ((r -= 0.5 * (o - f)), (h -= 0.5 * (o - f))),
          i > p)
        ) {
          (c = 0.5 * (i - p)), (l = -1 * c);
          let t = 0.5 * (d.bottom - d.top);
          (l += t), (c += t);
        }
        a > p && i < p && ((r -= 0.5 * (a - p)), (h -= 0.5 * (a - p)));
      }
      return { x: { min: r, max: h }, y: { min: l, max: c } };
    }
    getBounds() {
      const t = this.option("bounds");
      return t !== L ? t : this.calculateBounds();
    }
    updateControls() {
      const t = this,
        i = t.container,
        { panMode: n, contentRect: s, targetScale: a, minScale: r } = t;
      let l = r,
        h = t.option("click") || !1;
      h && (l = t.getNextScale(h));
      let c = t.canZoomIn(),
        d = t.canZoomOut(),
        u = n === k && !!this.option("touch"),
        g = d && u;
      if (
        (u &&
          (e(a) < e(r) && !this.panOnlyZoomed && (g = !0),
          (e(s.width, 1) > e(s.fitWidth, 1) ||
            e(s.height, 1) > e(s.fitHeight, 1)) &&
            (g = !0)),
        e(s.width * a, 1) < e(s.fitWidth, 1) && (g = !1),
        n === E && (g = !1),
        o(i, this.cn("isDraggable"), g),
        !this.option("zoom"))
      )
        return;
      let f = c && e(l) > e(a),
        p = !f && !g && d && e(l) < e(a);
      o(i, this.cn("canZoomIn"), f), o(i, this.cn("canZoomOut"), p);
      for (const t of i.querySelectorAll("[data-panzoom-action]")) {
        let e = !1,
          i = !1;
        switch (t.dataset.panzoomAction) {
          case "zoomIn":
            c ? (e = !0) : (i = !0);
            break;
          case "zoomOut":
            d ? (e = !0) : (i = !0);
            break;
          case "toggleZoom":
          case "iterateZoom":
            c || d ? (e = !0) : (i = !0);
            const n = t.querySelector("g");
            n && (n.style.display = c ? "" : "none");
        }
        e
          ? (t.removeAttribute("disabled"), t.removeAttribute("tabindex"))
          : i &&
            (t.setAttribute("disabled", ""), t.setAttribute("tabindex", "-1"));
      }
    }
    panTo({
      x: t = this.target.e,
      y: e = this.target.f,
      scale: i = this.targetScale,
      friction: n = this.option("friction"),
      angle: s = 0,
      originX: o = 0,
      originY: a = 0,
      flipX: r = !1,
      flipY: l = !1,
      ignoreBounds: h = !1,
    }) {
      this.state !== m.Destroy &&
        this.applyChange({
          panX: t - this.target.e,
          panY: e - this.target.f,
          scale: i / this.targetScale,
          angle: s,
          originX: o,
          originY: a,
          friction: n,
          flipX: r,
          flipY: l,
          ignoreBounds: h,
        });
    }
    applyChange({
      panX: t = 0,
      panY: i = 0,
      scale: n = 1,
      angle: s = 0,
      originX: o = -this.current.e,
      originY: a = -this.current.f,
      friction: r = this.option("friction"),
      flipX: l = !1,
      flipY: h = !1,
      ignoreBounds: c = !1,
      bounce: d = this.option("bounce"),
    }) {
      const u = this.state;
      if (u === m.Destroy) return;
      this.rAF && (cancelAnimationFrame(this.rAF), (this.rAF = null)),
        (this.friction = r || 0),
        (this.ignoreBounds = c);
      const { current: g } = this,
        f = g.e,
        p = g.f,
        v = this.getMatrix(this.target);
      let y = new DOMMatrix().translate(f, p).translate(o, a).translate(t, i);
      if (this.option("zoom")) {
        if (!c) {
          const t = this.targetScale,
            e = this.minScale,
            i = this.maxScale;
          t * n < e && (n = e / t), t * n > i && (n = i / t);
        }
        y = y.scale(n);
      }
      (y = y.translate(-o, -a).translate(-f, -p).multiply(v)),
        s && (y = y.rotate(s)),
        l && (y = y.scale(-1, 1)),
        h && (y = y.scale(1, -1));
      for (const t of b)
        "e" !== t &&
        "f" !== t &&
        (y[t] > this.minScale + 1e-5 || y[t] < this.minScale - 1e-5)
          ? (this.target[t] = y[t])
          : (this.target[t] = e(y[t], O));
      (this.targetScale < this.scale ||
        Math.abs(n - 1) > 0.1 ||
        this.panMode === E ||
        !1 === d) &&
        !c &&
        this.clampTargetBounds(),
        u === m.Init
          ? this.animate()
          : this.isResting || ((this.state = m.Panning), this.requestTick());
    }
    stop(t = !1) {
      if (this.state === m.Init || this.state === m.Destroy) return;
      const e = this.isTicking;
      this.rAF && (cancelAnimationFrame(this.rAF), (this.rAF = null)),
        (this.isBouncingX = !1),
        (this.isBouncingY = !1);
      for (const e of b)
        (this.velocity[e] = 0),
          "current" === t
            ? (this.current[e] = this.target[e])
            : "target" === t && (this.target[e] = this.current[e]);
      this.setTransform(),
        P(this.container, "is-scaling"),
        P(this.container, "is-animating"),
        (this.isTicking = !1),
        (this.state = m.Ready),
        e && (this.emit("endAnimation"), this.updateControls());
    }
    requestTick() {
      this.isTicking ||
        (this.emit("startAnimation"),
        this.updateControls(),
        T(this.container, "is-animating"),
        this.isScaling && T(this.container, "is-scaling")),
        (this.isTicking = !0),
        this.rAF || (this.rAF = requestAnimationFrame(() => this.animate()));
    }
    panWithMouse(t, i = this.option("mouseMoveFriction")) {
      if (((this.pmme = t), this.panMode !== E || !t)) return;
      if (e(this.targetScale) <= e(this.minScale)) return;
      this.emit("mouseMove", t);
      const { container: n, containerRect: s, contentRect: o } = this,
        a = s.width,
        r = s.height,
        l = n.getBoundingClientRect(),
        h = (t.clientX || 0) - l.left,
        c = (t.clientY || 0) - l.top;
      let { contentWidth: d, contentHeight: u } = this.calculateContentDim(
        this.target
      );
      const g = this.option("mouseMoveFactor");
      g > 1 && (d !== a && (d *= g), u !== r && (u *= g));
      let f = 0.5 * (d - a) - (((h / a) * 100) / 100) * (d - a);
      f += 0.5 * (o.right - o.left);
      let p = 0.5 * (u - r) - (((c / r) * 100) / 100) * (u - r);
      (p += 0.5 * (o.bottom - o.top)),
        this.applyChange({
          panX: f - this.target.e,
          panY: p - this.target.f,
          friction: i,
        });
    }
    zoomWithWheel(t) {
      if (this.state === m.Destroy || this.state === m.Init) return;
      const i = Date.now();
      if (i - this.pwt < 45) return void t.preventDefault();
      this.pwt = i;
      var n = [-t.deltaX || 0, -t.deltaY || 0, -t.detail || 0].reduce(function (
        t,
        e
      ) {
        return Math.abs(e) > Math.abs(t) ? e : t;
      });
      const s = Math.max(-1, Math.min(1, n)),
        { targetScale: o, maxScale: a, minScale: r } = this;
      let l = (o * (100 + 45 * s)) / 100;
      e(l) < e(r) && e(o) <= e(r)
        ? ((this.cwd += Math.abs(s)), (l = r))
        : e(l) > e(a) && e(o) >= e(a)
        ? ((this.cwd += Math.abs(s)), (l = a))
        : ((this.cwd = 0), (l = Math.max(Math.min(l, a), r))),
        this.cwd > this.option("wheelLimit") ||
          (t.preventDefault(), e(l) !== e(o) && this.zoomTo(l, { event: t }));
    }
    canZoomIn() {
      return (
        this.option("zoom") &&
        (e(this.contentRect.width, 1) < e(this.contentRect.fitWidth, 1) ||
          e(this.targetScale) < e(this.maxScale))
      );
    }
    canZoomOut() {
      return this.option("zoom") && e(this.targetScale) > e(this.minScale);
    }
    zoomIn(t = 1.25, e) {
      this.zoomTo(this.targetScale * t, e);
    }
    zoomOut(t = 0.8, e) {
      this.zoomTo(this.targetScale * t, e);
    }
    zoomToFit(t) {
      this.zoomTo("fit", t);
    }
    zoomToCover(t) {
      this.zoomTo("cover", t);
    }
    zoomToFull(t) {
      this.zoomTo("full", t);
    }
    zoomToMax(t) {
      this.zoomTo("max", t);
    }
    toggleZoom(t) {
      this.zoomTo(this.getNextScale("toggleZoom"), t);
    }
    toggleMax(t) {
      this.zoomTo(this.getNextScale("toggleMax"), t);
    }
    toggleCover(t) {
      this.zoomTo(this.getNextScale("toggleCover"), t);
    }
    iterateZoom(t) {
      this.zoomTo("next", t);
    }
    zoomTo(
      t = 1,
      { friction: e = L, originX: i = L, originY: n = L, event: s } = {}
    ) {
      if (this.isContentLoading || this.state === m.Destroy) return;
      const { targetScale: o, fullScale: a, maxScale: r, coverScale: l } = this;
      if (
        (this.stop(),
        this.panMode === E && (s = this.pmme || s),
        s || i === L || n === L)
      ) {
        const t = this.content.getBoundingClientRect(),
          e = this.container.getBoundingClientRect(),
          o = s ? s.clientX : e.left + 0.5 * e.width,
          a = s ? s.clientY : e.top + 0.5 * e.height;
        (i = o - t.left - 0.5 * t.width), (n = a - t.top - 0.5 * t.height);
      }
      let h = 1;
      "number" == typeof t
        ? (h = t)
        : "full" === t
        ? (h = a)
        : "cover" === t
        ? (h = l)
        : "max" === t
        ? (h = r)
        : "fit" === t
        ? (h = 1)
        : "next" === t && (h = this.getNextScale("iterateZoom")),
        (h = h / o || 1),
        (e = e === L ? (h > 1 ? 0.15 : 0.25) : e),
        this.applyChange({ scale: h, originX: i, originY: n, friction: e }),
        s && this.panMode === E && this.panWithMouse(s, e);
    }
    rotateCCW() {
      this.applyChange({ angle: -90 });
    }
    rotateCW() {
      this.applyChange({ angle: 90 });
    }
    flipX() {
      this.applyChange({ flipX: !0 });
    }
    flipY() {
      this.applyChange({ flipY: !0 });
    }
    fitX() {
      this.stop("target");
      const { containerRect: t, contentRect: e, target: i } = this;
      this.applyChange({
        panX: 0.5 * t.width - (e.left + 0.5 * e.fitWidth) - i.e,
        panY: 0.5 * t.height - (e.top + 0.5 * e.fitHeight) - i.f,
        scale: t.width / e.fitWidth / this.targetScale,
        originX: 0,
        originY: 0,
        ignoreBounds: !0,
      });
    }
    fitY() {
      this.stop("target");
      const { containerRect: t, contentRect: e, target: i } = this;
      this.applyChange({
        panX: 0.5 * t.width - (e.left + 0.5 * e.fitWidth) - i.e,
        panY: 0.5 * t.innerHeight - (e.top + 0.5 * e.fitHeight) - i.f,
        scale: t.height / e.fitHeight / this.targetScale,
        originX: 0,
        originY: 0,
        ignoreBounds: !0,
      });
    }
    toggleFS() {
      const { container: t } = this,
        e = this.cn("inFullscreen"),
        i = this.cn("htmlHasFullscreen");
      t.classList.toggle(e);
      const n = t.classList.contains(e);
      n
        ? (document.documentElement.classList.add(i),
          document.addEventListener("keydown", this.onKeydown, !0))
        : (document.documentElement.classList.remove(i),
          document.removeEventListener("keydown", this.onKeydown, !0)),
        this.updateMetrics(),
        this.emit(n ? "enterFS" : "exitFS");
    }
    getMatrix(t = this.current) {
      const { a: e, b: i, c: n, d: s, e: o, f: a } = t;
      return new DOMMatrix([e, i, n, s, o, a]);
    }
    reset(t) {
      if (this.state !== m.Init && this.state !== m.Destroy) {
        this.stop("current");
        for (const t of b) this.target[t] = S[t];
        (this.target.a = this.minScale),
          (this.target.d = this.minScale),
          this.clampTargetBounds(),
          this.isResting ||
            ((this.friction = void 0 === t ? this.option("friction") : t),
            (this.state = m.Panning),
            this.requestTick());
      }
    }
    destroy() {
      this.stop(),
        (this.state = m.Destroy),
        this.detachEvents(),
        this.detachObserver();
      const { container: t, content: e } = this,
        i = this.option("classes") || {};
      for (const e of Object.values(i)) t.classList.remove(e + "");
      e &&
        (e.removeEventListener("load", this.onLoad),
        e.removeEventListener("error", this.onError)),
        this.detachPlugins();
    }
  }
  Object.defineProperty(R, "defaults", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: v,
  }),
    Object.defineProperty(R, "Plugins", {
      enumerable: !0,
      configurable: !0,
      writable: !0,
      value: {},
    });
  const A = function (t, e) {
      let i = !0;
      return (...n) => {
        i &&
          ((i = !1),
          t(...n),
          setTimeout(() => {
            i = !0;
          }, e));
      };
    },
    j = (t, e) => {
      let i = [];
      return (
        t.childNodes.forEach((t) => {
          t.nodeType !== Node.ELEMENT_NODE || (e && !t.matches(e)) || i.push(t);
        }),
        i
      );
    },
    F = {
      viewport: null,
      track: null,
      enabled: !0,
      slides: [],
      axis: "x",
      transition: "fade",
      preload: 1,
      slidesPerPage: "auto",
      initialPage: 0,
      friction: 0.01,

      // carousel  speed control from here

      Panzoom: { decelFriction: 0.12 },
      center: !0,
      infinite: !0,
      fill: !0,
      dragFree: !1,
      adaptiveHeight: !1,
      direction: "ltr",
      classes: {
        container: "f-carousel",
        viewport: "f-carousel__viewport",
        track: "f-carousel__track",
        slide: "f-carousel__slide",
        isLTR: "is-ltr",
        isRTL: "is-rtl",
        isHorizontal: "is-horizontal",
        isVertical: "is-vertical",
        inTransition: "in-transition",
        isSelected: "is-selected",
      },
      l10n: {
        NEXT: "Next slide",
        PREV: "Previous slide",
        GOTO: "Go to slide #%d",
      },
    };
  var I;
  !(function (t) {
    (t[(t.Init = 0)] = "Init"),
      (t[(t.Ready = 1)] = "Ready"),
      (t[(t.Destroy = 2)] = "Destroy");
  })(I || (I = {}));
  const B = (t) => {
      if ("string" == typeof t || t instanceof HTMLElement) t = { html: t };
      else {
        const e = t.thumb;
        void 0 !== e &&
          ("string" == typeof e && (t.thumbSrc = e),
          e instanceof HTMLImageElement &&
            ((t.thumbEl = e), (t.thumbElSrc = e.src), (t.thumbSrc = e.src)),
          delete t.thumb);
      }
      return Object.assign(
        {
          html: "",
          el: null,
          isDom: !1,
          class: "",
          customClass: "",
          index: -1,
          dim: 0,
          gap: 0,
          pos: 0,
          transition: !1,
        },
        t
      );
    },
    H = (t = {}) =>
      Object.assign({ index: -1, slides: [], dim: 0, pos: -1 }, t);
  class N extends f {
    constructor(t, e) {
      super(e),
        Object.defineProperty(this, "instance", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: t,
        });
    }
    attach() {}
    detach() {}
  }
  const X = {
    classes: {
      list: "f-carousel__dots",
      isDynamic: "is-dynamic",
      hasDots: "has-dots",
      dot: "f-carousel__dot",
      isBeforePrev: "is-before-prev",
      isPrev: "is-prev",
      isCurrent: "is-current",
      isNext: "is-next",
      isAfterNext: "is-after-next",
    },
    dotTpl:
      '<button type="button" data-carousel-page="%i" aria-label="{{GOTO}}"><span class="f-carousel__dot" aria-hidden="true"></span></button>',
    dynamicFrom: 11,
    maxCount: 1 / 0,
    minCount: 2,
  };
  class W extends N {
    constructor() {
      super(...arguments),
        Object.defineProperty(this, "isDynamic", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "list", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        });
    }
    onRefresh() {
      this.refresh();
    }
    build() {
      let t = this.list;
      if (!t) {
        (t = document.createElement("ul")),
          T(t, this.cn("list")),
          t.setAttribute("role", "tablist");
        const e = this.instance.container;
        e.appendChild(t), T(e, this.cn("hasDots")), (this.list = t);
      }
      return t;
    }
    refresh() {
      var t;
      const e = this.instance.pages.length,
        i = Math.min(2, this.option("minCount")),
        n = Math.max(2e3, this.option("maxCount")),
        s = this.option("dynamicFrom");
      if (e < i || e > n) return void this.cleanup();
      const a = "number" == typeof s && e > 5 && e >= s,
        r =
          !this.list || this.isDynamic !== a || this.list.children.length !== e;
      r && this.cleanup();
      const l = this.build();
      if ((o(l, this.cn("isDynamic"), !!a), r))
        for (let t = 0; t < e; t++) l.append(this.createItem(t));
      let h,
        c = 0;
      for (const e of [...l.children]) {
        const i = c === this.instance.page;
        i && (h = e),
          o(e, this.cn("isCurrent"), i),
          null === (t = e.children[0]) ||
            void 0 === t ||
            t.setAttribute("aria-selected", i ? "true" : "false");
        for (const t of ["isBeforePrev", "isPrev", "isNext", "isAfterNext"])
          P(e, this.cn(t));
        c++;
      }
      if (((h = h || l.firstChild), a && h)) {
        const t = h.previousElementSibling,
          e = t && t.previousElementSibling;
        T(t, this.cn("isPrev")), T(e, this.cn("isBeforePrev"));
        const i = h.nextElementSibling,
          n = i && i.nextElementSibling;
        T(i, this.cn("isNext")), T(n, this.cn("isAfterNext"));
      }
      this.isDynamic = a;
    }
    createItem(t = 0) {
      var e;
      const i = document.createElement("li");
      i.setAttribute("role", "presentation");
      const s = n(
        this.instance
          .localize(this.option("dotTpl"), [["%d", t + 1]])
          .replace(/\%i/g, t + "")
      );
      return (
        i.appendChild(s),
        null === (e = i.children[0]) ||
          void 0 === e ||
          e.setAttribute("role", "tab"),
        i
      );
    }
    cleanup() {
      this.list && (this.list.remove(), (this.list = null)),
        (this.isDynamic = !1),
        P(this.instance.container, this.cn("hasDots"));
    }
    attach() {
      this.instance.on(["refresh", "change"], this.onRefresh);
    }
    detach() {
      this.instance.off(["refresh", "change"], this.onRefresh), this.cleanup();
    }
  }
  Object.defineProperty(W, "defaults", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: X,
  });
  const Y = "disabled",
    $ = "next",
    Z = "prev";
  class V extends N {
    constructor() {
      super(...arguments),
        Object.defineProperty(this, "container", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "prev", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "next", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "isDom", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        });
    }
    onRefresh() {
      const t = this.instance,
        e = t.pages.length,
        i = t.page;
      if (e < 2) return void this.cleanup();
      this.build();
      let n = this.prev,
        s = this.next;
      n &&
        s &&
        (n.removeAttribute(Y),
        s.removeAttribute(Y),
        t.isInfinite ||
          (i <= 0 && n.setAttribute(Y, ""),
          i >= e - 1 && s.setAttribute(Y, "")));
    }
    addBtn(t) {
      var e;
      const i = this.instance,
        n = document.createElement("button");
      n.setAttribute("tabindex", "0"),
        n.setAttribute("title", i.localize(`{{${t.toUpperCase()}}}`)),
        T(n, this.cn("button") + " " + this.cn(t === $ ? "isNext" : "isPrev"));
      const s = i.isRTL ? (t === $ ? Z : $) : t;
      var o;
      return (
        (n.innerHTML = i.localize(this.option(`${s}Tpl`))),
        (n.dataset[
          `carousel${
            ((o = t),
            o
              ? o.match("^[a-z]")
                ? o.charAt(0).toUpperCase() + o.substring(1)
                : o
              : "")
          }`
        ] = "true"),
        null === (e = this.container) || void 0 === e || e.appendChild(n),
        n
      );
    }
    build() {
      const t = this.instance.container,
        e = this.cn("container");
      let { container: i, prev: n, next: s } = this;
      i || ((i = t.querySelector("." + e)), (this.isDom = !!i)),
        i || ((i = document.createElement("div")), T(i, e), t.appendChild(i)),
        (this.container = i),
        s || (s = i.querySelector("[data-carousel-next]")),
        s || (s = this.addBtn($)),
        (this.next = s),
        n || (n = i.querySelector("[data-carousel-prev]")),
        n || (n = this.addBtn(Z)),
        (this.prev = n);
    }
    cleanup() {
      this.isDom ||
        (this.prev && this.prev.remove(),
        this.next && this.next.remove(),
        this.container && this.container.remove()),
        (this.prev = null),
        (this.next = null),
        (this.container = null),
        (this.isDom = !1);
    }
    attach() {
      this.instance.on(["refresh", "change"], this.onRefresh);
    }
    detach() {
      this.instance.off(["refresh", "change"], this.onRefresh), this.cleanup();
    }
  }
  Object.defineProperty(V, "defaults", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: {
      classes: {
        container: "f-carousel__nav",
        button: "f-button",
        isNext: "is-next",
        isPrev: "is-prev",
      },
      nextTpl:
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>',
      prevTpl:
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>',
    },
  });
  class q extends N {
    constructor() {
      super(...arguments),
        Object.defineProperty(this, "selectedIndex", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "target", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "nav", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        });
    }
    addAsTargetFor(t) {
      (this.target = this.instance), (this.nav = t), this.attachEvents();
    }
    addAsNavFor(t) {
      (this.nav = this.instance), (this.target = t), this.attachEvents();
    }
    attachEvents() {
      const { nav: t, target: e } = this;
      t &&
        e &&
        ((t.options.initialSlide = e.options.initialPage),
        t.state === I.Ready
          ? this.onNavReady(t)
          : t.on("ready", this.onNavReady),
        e.state === I.Ready
          ? this.onTargetReady(e)
          : e.on("ready", this.onTargetReady));
    }
    onNavReady(t) {
      t.on("createSlide", this.onNavCreateSlide),
        t.on("Panzoom.click", this.onNavClick),
        t.on("Panzoom.touchEnd", this.onNavTouch),
        this.onTargetChange();
    }
    onTargetReady(t) {
      t.on("change", this.onTargetChange),
        t.on("Panzoom.refresh", this.onTargetChange),
        this.onTargetChange();
    }
    onNavClick(t, e, i) {
      this.onNavTouch(t, t.panzoom, i);
    }
    onNavTouch(t, e, i) {
      var n, s;
      if (Math.abs(e.dragOffset.x) > 3 || Math.abs(e.dragOffset.y) > 3) return;
      const o = i.target,
        { nav: a, target: r } = this;
      if (!a || !r || !o) return;
      const l = o.closest("[data-index]");
      if ((i.stopPropagation(), i.preventDefault(), !l)) return;
      const h = parseInt(l.dataset.index || "", 10) || 0,
        c = r.getPageForSlide(h),
        d = a.getPageForSlide(h);
      a.slideTo(d),
        r.slideTo(c, {
          friction:
            (null ===
              (s =
                null === (n = this.nav) || void 0 === n ? void 0 : n.plugins) ||
            void 0 === s
              ? void 0
              : s.Sync.option("friction")) || 0,
        }),
        this.markSelectedSlide(h);
    }
    onNavCreateSlide(t, e) {
      e.index === this.selectedIndex && this.markSelectedSlide(e.index);
    }
    onTargetChange() {
      var t, e;
      const { target: i, nav: n } = this;
      if (!i || !n) return;
      if (n.state !== I.Ready || i.state !== I.Ready) return;
      const s =
          null ===
            (e =
              null === (t = i.pages[i.page]) || void 0 === t
                ? void 0
                : t.slides[0]) || void 0 === e
            ? void 0
            : e.index,
        o = n.getPageForSlide(s);
      this.markSelectedSlide(s),
        n.slideTo(
          o,
          null === n.prevPage && null === i.prevPage ? { friction: 0 } : void 0
        );
    }
    markSelectedSlide(t) {
      const e = this.nav;
      e &&
        e.state === I.Ready &&
        ((this.selectedIndex = t),
        [...e.slides].map((e) => {
          e.el &&
            e.el.classList[e.index === t ? "add" : "remove"]("is-nav-selected");
        }));
    }
    attach() {
      const t = this;
      let e = t.options.target,
        i = t.options.nav;
      e ? t.addAsNavFor(e) : i && t.addAsTargetFor(i);
    }
    detach() {
      const t = this,
        e = t.nav,
        i = t.target;
      e &&
        (e.off("ready", t.onNavReady),
        e.off("createSlide", t.onNavCreateSlide),
        e.off("Panzoom.click", t.onNavClick),
        e.off("Panzoom.touchEnd", t.onNavTouch)),
        (t.nav = null),
        i &&
          (i.off("ready", t.onTargetReady),
          i.off("refresh", t.onTargetChange),
          i.off("change", t.onTargetChange)),
        (t.target = null);
    }
  }
  Object.defineProperty(q, "defaults", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: { friction: 0.35 },
  });
  const _ = { Navigation: V, Dots: W, Sync: q },
    G = "animationend",
    U = "isSelected",
    K = "slide";
  class J extends p {
    get axis() {
      return this.isHorizontal ? "e" : "f";
    }
    get isEnabled() {
      return this.state === I.Ready;
    }
    get isInfinite() {
      let t = !1;
      const { contentDim: e, viewportDim: i, pages: n, slides: s } = this,
        o = s[0];
      return (
        n.length >= 2 && o && e + o.dim >= i && (t = this.option("infinite")), t
      );
    }
    get isRTL() {
      return "rtl" === this.option("direction");
    }
    get isHorizontal() {
      return "x" === this.option("axis");
    }
    constructor(t, e = {}, i = {}) {
      if (
        (super(),
        Object.defineProperty(this, "bp", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: "",
        }),
        Object.defineProperty(this, "lp", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "userOptions", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: {},
        }),
        Object.defineProperty(this, "userPlugins", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: {},
        }),
        Object.defineProperty(this, "state", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: I.Init,
        }),
        Object.defineProperty(this, "page", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "prevPage", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "container", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: void 0,
        }),
        Object.defineProperty(this, "viewport", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "track", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "slides", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: [],
        }),
        Object.defineProperty(this, "pages", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: [],
        }),
        Object.defineProperty(this, "panzoom", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "inTransition", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: new Set(),
        }),
        Object.defineProperty(this, "contentDim", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        Object.defineProperty(this, "viewportDim", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: 0,
        }),
        "string" == typeof t && (t = document.querySelector(t)),
        !t || !x(t))
      )
        throw new Error("No Element found");
      (this.container = t),
        (this.slideNext = A(this.slideNext.bind(this), 150)),
        (this.slidePrev = A(this.slidePrev.bind(this), 150)),
        (this.userOptions = e),
        (this.userPlugins = i),
        queueMicrotask(() => {
          this.processOptions();
        });
    }
    processOptions() {
      var t, e;
      const i = u({}, J.defaults, this.userOptions);
      let n = "";
      const s = i.breakpoints;
      if (s && d(s))
        for (const [t, e] of Object.entries(s))
          window.matchMedia(t).matches && d(e) && ((n += t), u(i, e));
      (n === this.bp && this.state !== I.Init) ||
        ((this.bp = n),
        this.state === I.Ready &&
          (i.initialSlide =
            (null ===
              (e =
                null === (t = this.pages[this.page]) || void 0 === t
                  ? void 0
                  : t.slides[0]) || void 0 === e
              ? void 0
              : e.index) || 0),
        this.state !== I.Init && this.destroy(),
        super.setOptions(i),
        !1 === this.option("enabled")
          ? this.attachEvents()
          : setTimeout(() => {
              this.init();
            }, 0));
    }
    init() {
      (this.state = I.Init),
        this.emit("init"),
        this.attachPlugins(
          Object.assign(Object.assign({}, J.Plugins), this.userPlugins)
        ),
        this.emit("attachPlugins"),
        this.initLayout(),
        this.initSlides(),
        this.updateMetrics(),
        this.setInitialPosition(),
        this.initPanzoom(),
        this.attachEvents(),
        (this.state = I.Ready),
        this.emit("ready");
    }
    initLayout() {
      const { container: t } = this,
        e = this.option("classes");
      T(t, this.cn("container")),
        o(t, e.isLTR, !this.isRTL),
        o(t, e.isRTL, this.isRTL),
        o(t, e.isVertical, !this.isHorizontal),
        o(t, e.isHorizontal, this.isHorizontal);
      let i = this.option("viewport") || t.querySelector(`.${e.viewport}`);
      i ||
        ((i = document.createElement("div")),
        T(i, e.viewport),
        i.append(...j(t, `.${e.slide}`)),
        t.prepend(i)),
        i.addEventListener("scroll", this.onScroll);
      let n = this.option("track") || t.querySelector(`.${e.track}`);
      n ||
        ((n = document.createElement("div")),
        T(n, e.track),
        n.append(...Array.from(i.childNodes))),
        n.setAttribute("aria-live", "polite"),
        i.contains(n) || i.prepend(n),
        (this.viewport = i),
        (this.track = n),
        this.emit("initLayout");
    }
    initSlides() {
      const { track: t } = this;
      if (!t) return;
      const e = [...this.slides],
        i = [];
      [...j(t, `.${this.cn(K)}`)].forEach((t) => {
        if (x(t)) {
          const e = B({ el: t, isDom: !0, index: this.slides.length });
          i.push(e);
        }
      });
      for (let t of [...(this.option("slides", []) || []), ...e]) i.push(B(t));
      this.slides = i;
      for (let t = 0; t < this.slides.length; t++) this.slides[t].index = t;
      for (const t of i)
        this.emit("beforeInitSlide", t, t.index),
          this.emit("initSlide", t, t.index);
      this.emit("initSlides");
    }
    setInitialPage() {
      const t = this.option("initialSlide");
      this.page =
        "number" == typeof t
          ? this.getPageForSlide(t)
          : parseInt(this.option("initialPage", 0) + "", 10) || 0;
    }
    setInitialPosition() {
      const { track: t, pages: e, isHorizontal: i } = this;
      if (!t || !e.length) return;
      let n = this.page;
      e[n] || (this.page = n = 0);
      const s = (e[n].pos || 0) * (this.isRTL && i ? 1 : -1),
        o = i ? `${s}px` : "0",
        a = i ? "0" : `${s}px`;
      (t.style.transform = `translate3d(${o}, ${a}, 0) scale(1)`),
        this.option("adaptiveHeight") && this.setViewportHeight();
    }
    initPanzoom() {
      this.panzoom && (this.panzoom.destroy(), (this.panzoom = null));
      const t = this.option("Panzoom") || {};
      (this.panzoom = new R(
        this.viewport,
        u(
          {},
          {
            content: this.track,
            zoom: !1,
            panOnlyZoomed: !1,
            lockAxis: this.isHorizontal ? "x" : "y",
            infinite: this.isInfinite,
            click: !1,
            dblClick: !1,
            touch: (t) => !(this.pages.length < 2 && !t.options.infinite),
            bounds: () => this.getBounds(),
            maxVelocity: (t) =>
              Math.abs(t.target[this.axis] - t.current[this.axis]) <
              2 * this.viewportDim
                ? 100
                : 0,
          },
          t
        )
      )),
        this.panzoom.on("*", (t, e, ...i) => {
          this.emit(`Panzoom.${e}`, t, ...i);
        }),
        this.panzoom.on("decel", this.onDecel),
        this.panzoom.on("refresh", this.onRefresh),
        this.panzoom.on("beforeTransform", this.onBeforeTransform),
        this.panzoom.on("endAnimation", this.onEndAnimation);
    }
    attachEvents() {
      const t = this.container;
      t &&
        (t.addEventListener("click", this.onClick, {
          passive: !1,
          capture: !1,
        }),
        t.addEventListener("slideTo", this.onSlideTo)),
        window.addEventListener("resize", this.onResize);
    }
    createPages() {
      let t = [];
      const { contentDim: e, viewportDim: i } = this;
      let n = this.option("slidesPerPage");
      n =
        ("auto" === n || e <= i) && !1 !== this.option("fill")
          ? 1 / 0
          : parseFloat(n + "");
      let s = 0,
        o = 0,
        a = 0;
      for (const e of this.slides)
        (!t.length || o + e.dim - i > 0.05 || a >= n) &&
          (t.push(H()), (s = t.length - 1), (o = 0), (a = 0)),
          t[s].slides.push(e),
          (o += e.dim + e.gap),
          a++;
      return t;
    }
    processPages() {
      const t = this.pages,
        { contentDim: i, viewportDim: n, isInfinite: s } = this,
        o = this.option("center"),
        a = this.option("fill"),
        r = a && o && i > n && !s;
      if (
        (t.forEach((t, e) => {
          var s;
          (t.index = e),
            (t.pos =
              (null === (s = t.slides[0]) || void 0 === s ? void 0 : s.pos) ||
              0),
            (t.dim = 0);
          for (const [e, i] of t.slides.entries())
            (t.dim += i.dim), e < t.slides.length - 1 && (t.dim += i.gap);
          r && t.pos + 0.5 * t.dim < 0.5 * n
            ? (t.pos = 0)
            : r && t.pos + 0.5 * t.dim >= i - 0.5 * n
            ? (t.pos = i - n)
            : o && (t.pos += -0.5 * (n - t.dim));
        }),
        t.forEach((t) => {
          a &&
            !s &&
            i > n &&
            ((t.pos = Math.max(t.pos, 0)), (t.pos = Math.min(t.pos, i - n))),
            (t.pos = e(t.pos, 1e3)),
            (t.dim = e(t.dim, 1e3)),
            Math.abs(t.pos) <= 0.1 && (t.pos = 0);
        }),
        s)
      )
        return t;
      const l = [];
      let h;
      return (
        t.forEach((t) => {
          const e = Object.assign({}, t);
          h && e.pos === h.pos
            ? ((h.dim += e.dim), (h.slides = [...h.slides, ...e.slides]))
            : ((e.index = l.length), (h = e), l.push(e));
        }),
        l
      );
    }
    getPageFromIndex(t = 0) {
      const e = this.pages.length;
      let i;
      return (
        (t = parseInt((t || 0).toString()) || 0),
        (i = this.isInfinite
          ? ((t % e) + e) % e
          : Math.max(Math.min(t, e - 1), 0)),
        i
      );
    }
    getSlideMetrics(t) {
      var i, n;
      const s = this.isHorizontal ? "width" : "height";
      let o = 0,
        a = 0,
        r = t.el;
      const l = !(!r || r.parentNode);
      if (
        (r
          ? (o = parseFloat(r.dataset[s] || "") || 0)
          : ((r = document.createElement("div")),
            (r.style.visibility = "hidden"),
            (this.track || document.body).prepend(r)),
        T(r, this.cn(K) + " " + t.class + " " + t.customClass),
        o)
      )
        (r.style[s] = `${o}px`),
          (r.style["width" === s ? "height" : "width"] = "");
      else {
        l && (this.track || document.body).prepend(r),
          (o =
            r.getBoundingClientRect()[s] *
            Math.max(
              1,
              (null === (i = window.visualViewport) || void 0 === i
                ? void 0
                : i.scale) || 1
            ));
        let t = r[this.isHorizontal ? "offsetWidth" : "offsetHeight"];
        t - 1 > o && (o = t);
      }
      const h = getComputedStyle(r);
      return (
        "content-box" === h.boxSizing &&
          (this.isHorizontal
            ? ((o += parseFloat(h.paddingLeft) || 0),
              (o += parseFloat(h.paddingRight) || 0))
            : ((o += parseFloat(h.paddingTop) || 0),
              (o += parseFloat(h.paddingBottom) || 0))),
        (a =
          parseFloat(h[this.isHorizontal ? "marginRight" : "marginBottom"]) ||
          0),
        l
          ? null === (n = r.parentElement) || void 0 === n || n.removeChild(r)
          : t.el || r.remove(),
        { dim: e(o, 1e3), gap: e(a, 1e3) }
      );
    }
    getBounds() {
      const { isInfinite: t, isRTL: e, isHorizontal: i, pages: n } = this;
      let s = { min: 0, max: 0 };
      if (t) s = { min: -1 / 0, max: 1 / 0 };
      else if (n.length) {
        const t = n[0].pos,
          o = n[n.length - 1].pos;
        s = e && i ? { min: t, max: o } : { min: -1 * o, max: -1 * t };
      }
      return { x: i ? s : { min: 0, max: 0 }, y: i ? { min: 0, max: 0 } : s };
    }
    repositionSlides() {
      let t,
        {
          isHorizontal: i,
          isRTL: n,
          isInfinite: s,
          viewport: o,
          viewportDim: a,
          contentDim: r,
          page: l,
          pages: h,
          slides: c,
          panzoom: d,
        } = this,
        u = 0,
        g = 0,
        f = 0,
        p = 0;
      d ? (p = -1 * d.current[this.axis]) : h[l] && (p = h[l].pos || 0),
        (t = i ? (n ? "right" : "left") : "top"),
        n && i && (p *= -1);
      for (const i of c) {
        const n = i.el;
        n
          ? ("top" === t
              ? ((n.style.right = ""), (n.style.left = ""))
              : (n.style.top = ""),
            i.index !== u
              ? (n.style[t] = 0 === g ? "" : `${e(g, 1e3)}px`)
              : (n.style[t] = ""),
            (f += i.dim + i.gap),
            u++)
          : (g += i.dim + i.gap);
      }
      if (s && f && o) {
        let n = getComputedStyle(o),
          s = "padding",
          l = i ? "Right" : "Bottom",
          h = parseFloat(n[s + (i ? "Left" : "Top")]);
        (p -= h), (a += h), (a += parseFloat(n[s + l]));
        for (const i of c)
          i.el &&
            (e(i.pos) < e(a) &&
              e(i.pos + i.dim + i.gap) < e(p) &&
              e(p) > e(r - a) &&
              (i.el.style[t] = `${e(g + f, 1e3)}px`),
            e(i.pos + i.gap) >= e(r - a) &&
              e(i.pos) > e(p + a) &&
              e(p) < e(a) &&
              (i.el.style[t] = `-${e(f, 1e3)}px`));
      }
      let m,
        b,
        v = [...this.inTransition];
      if ((v.length > 1 && ((m = h[v[0]]), (b = h[v[1]])), m && b)) {
        let i = 0;
        for (const n of c)
          n.el
            ? this.inTransition.has(n.index) &&
              m.slides.indexOf(n) < 0 &&
              (n.el.style[t] = `${e(i + (m.pos - b.pos), 1e3)}px`)
            : (i += n.dim + n.gap);
      }
    }
    createSlideEl(t) {
      const { track: e, slides: i } = this;
      if (!e || !t) return;
      if (t.el && t.el.parentNode) return;
      const n = t.el || document.createElement("div");
      T(n, this.cn(K)), T(n, t.class), T(n, t.customClass);
      const s = t.html;
      s &&
        (s instanceof HTMLElement
          ? n.appendChild(s)
          : (n.innerHTML = t.html + ""));
      const o = [];
      i.forEach((t, e) => {
        t.el && o.push(e);
      });
      const a = t.index;
      let r = null;
      if (o.length) {
        r = i[o.reduce((t, e) => (Math.abs(e - a) < Math.abs(t - a) ? e : t))];
      }
      const l =
        r && r.el && r.el.parentNode
          ? r.index < t.index
            ? r.el.nextSibling
            : r.el
          : null;
      e.insertBefore(n, e.contains(l) ? l : null),
        (t.el = n),
        this.emit("createSlide", t);
    }
    removeSlideEl(t, e = !1) {
      const i = null == t ? void 0 : t.el;
      if (!i || !i.parentNode) return;
      const n = this.cn(U);
      if (
        (i.classList.contains(n) && (P(i, n), this.emit("unselectSlide", t)),
        t.isDom && !e)
      )
        return (
          i.removeAttribute("aria-hidden"),
          i.removeAttribute("data-index"),
          void (i.style.left = "")
        );
      this.emit("removeSlide", t);
      const s = new CustomEvent(G);
      i.dispatchEvent(s), t.el && (t.el.remove(), (t.el = null));
    }
    transitionTo(t = 0, e = this.option("transition")) {
      var i, n, s, o;
      if (!e) return !1;
      const a = this.page,
        { pages: r, panzoom: l } = this;
      t = parseInt((t || 0).toString()) || 0;
      const h = this.getPageFromIndex(t);
      if (
        !l ||
        !r[h] ||
        r.length < 2 ||
        Math.abs(
          ((null ===
            (n = null === (i = r[a]) || void 0 === i ? void 0 : i.slides[0]) ||
          void 0 === n
            ? void 0
            : n.dim) || 0) - this.viewportDim
        ) > 1
      )
        return !1;
      let c = t > a ? 1 : -1;
      this.isInfinite &&
        (0 === a && t === r.length - 1 && (c = -1),
        a === r.length - 1 && 0 === t && (c = 1));
      const d = r[h].pos * (this.isRTL ? 1 : -1);
      if (a === h && Math.abs(d - l.target[this.axis]) < 1) return !1;
      this.clearTransitions();
      const u = l.isResting;
      T(this.container, this.cn("inTransition"));
      const g =
          (null === (s = r[a]) || void 0 === s ? void 0 : s.slides[0]) || null,
        f =
          (null === (o = r[h]) || void 0 === o ? void 0 : o.slides[0]) || null;
      this.inTransition.add(f.index), this.createSlideEl(f);
      let p = g.el,
        m = f.el;
      u || e === K || ((e = "fadeFast"), (p = null));
      const b = this.isRTL ? "next" : "prev",
        v = this.isRTL ? "prev" : "next";
      return (
        p &&
          (this.inTransition.add(g.index),
          (g.transition = e),
          p.addEventListener(G, this.onAnimationEnd),
          p.classList.add(`f-${e}Out`, `to-${c > 0 ? v : b}`)),
        m &&
          ((f.transition = e),
          m.addEventListener(G, this.onAnimationEnd),
          m.classList.add(`f-${e}In`, `from-${c > 0 ? b : v}`)),
        (l.current[this.axis] = d),
        (l.target[this.axis] = d),
        l.requestTick(),
        this.onChange(h),
        !0
      );
    }
    manageSlideVisiblity() {
      const t = new Set(),
        e = new Set(),
        i = this.getVisibleSlides(
          parseFloat(this.option("preload", 0) + "") || 0
        );
      for (const n of this.slides) i.has(n) ? t.add(n) : e.add(n);
      for (const e of this.inTransition) t.add(this.slides[e]);
      for (const e of t) this.createSlideEl(e), this.lazyLoadSlide(e);
      for (const i of e) t.has(i) || this.removeSlideEl(i);
      this.markSelectedSlides(), this.repositionSlides();
    }
    markSelectedSlides() {
      if (!this.pages[this.page] || !this.pages[this.page].slides) return;
      const t = "aria-hidden";
      let e = this.cn(U);
      if (e)
        for (const i of this.slides) {
          const n = i.el;
          n &&
            ((n.dataset.index = `${i.index}`),
            n.classList.contains("f-thumbs__slide")
              ? this.getVisibleSlides(0).has(i)
                ? n.removeAttribute(t)
                : n.setAttribute(t, "true")
              : this.pages[this.page].slides.includes(i)
              ? (n.classList.contains(e) ||
                  (T(n, e), this.emit("selectSlide", i)),
                n.removeAttribute(t))
              : (n.classList.contains(e) &&
                  (P(n, e), this.emit("unselectSlide", i)),
                n.setAttribute(t, "true")));
        }
    }
    flipInfiniteTrack() {
      const {
          axis: t,
          isHorizontal: e,
          isInfinite: i,
          isRTL: n,
          viewportDim: s,
          contentDim: o,
        } = this,
        a = this.panzoom;
      if (!a || !i) return;
      let r = a.current[t],
        l = a.target[t] - r,
        h = 0,
        c = 0.5 * s;
      n && e
        ? (r < -c && ((h = -1), (r += o)), r > o - c && ((h = 1), (r -= o)))
        : (r > c && ((h = 1), (r -= o)), r < -o + c && ((h = -1), (r += o))),
        h && ((a.current[t] = r), (a.target[t] = r + l));
    }
    lazyLoadImg(t, e) {
      const i = this,
        s = "f-fadeIn",
        o = "is-preloading";
      let a = !1,
        r = null;
      const l = () => {
        a ||
          ((a = !0),
          r && (r.remove(), (r = null)),
          P(e, o),
          e.complete &&
            (T(e, s),
            setTimeout(() => {
              P(e, s);
            }, 350)),
          this.option("adaptiveHeight") &&
            t.el &&
            this.pages[this.page].slides.indexOf(t) > -1 &&
            (i.updateMetrics(), i.setViewportHeight()),
          this.emit("load", t));
      };
      T(e, o),
        (e.src = e.dataset.lazySrcset || e.dataset.lazySrc || ""),
        delete e.dataset.lazySrc,
        delete e.dataset.lazySrcset,
        e.addEventListener("error", () => {
          l();
        }),
        e.addEventListener("load", () => {
          l();
        }),
        setTimeout(() => {
          const i = e.parentNode;
          i &&
            t.el &&
            (e.complete ? l() : a || ((r = n(w)), i.insertBefore(r, e)));
        }, 300);
    }
    lazyLoadSlide(t) {
      const e = t && t.el;
      if (!e) return;
      const i = new Set();
      let n = Array.from(
        e.querySelectorAll("[data-lazy-src],[data-lazy-srcset]")
      );
      e.dataset.lazySrc && n.push(e),
        n.map((t) => {
          t instanceof HTMLImageElement
            ? i.add(t)
            : t instanceof HTMLElement &&
              t.dataset.lazySrc &&
              ((t.style.backgroundImage = `url('${t.dataset.lazySrc}')`),
              delete t.dataset.lazySrc);
        });
      for (const e of i) this.lazyLoadImg(t, e);
    }
    onAnimationEnd(t) {
      var e;
      const i = t.target,
        n = i ? parseInt(i.dataset.index || "", 10) || 0 : -1,
        s = this.slides[n],
        o = t.animationName;
      if (!i || !s || !o) return;
      const a = !!this.inTransition.has(n) && s.transition;
      a &&
        o.substring(0, a.length + 2) === `f-${a}` &&
        this.inTransition.delete(n),
        this.inTransition.size || this.clearTransitions(),
        n === this.page &&
          (null === (e = this.panzoom) || void 0 === e
            ? void 0
            : e.isResting) &&
          this.emit("settle");
    }
    onDecel(t, e = 0, i = 0, n = 0, s = 0) {
      if (this.option("dragFree")) return void this.setPageFromPosition();
      const { isRTL: o, isHorizontal: a, axis: r, pages: l } = this,
        h = l.length,
        c = Math.abs(Math.atan2(i, e) / (Math.PI / 180));
      let d = 0;
      if (((d = c > 45 && c < 135 ? (a ? 0 : i) : a ? e : 0), !h)) return;
      let u = this.page,
        g = o && a ? 1 : -1;
      const f = t.current[r] * g;
      let { pageIndex: p } = this.getPageFromPosition(f);
      Math.abs(d) > 5
        ? (l[u].dim <
            document.documentElement[
              "client" + (this.isHorizontal ? "Width" : "Height")
            ] -
              1 && (u = p),
          (u = o && a ? (d < 0 ? u - 1 : u + 1) : d < 0 ? u + 1 : u - 1))
        : (u = 0 === n && 0 === s ? u : p),
        this.slideTo(u, {
          transition: !1,
          friction: t.option("decelFriction"),
        });
    }
    onClick(t) {
      const e = t.target,
        i = e && x(e) ? e.dataset : null;
      let n, s;
      i &&
        (void 0 !== i.carouselPage
          ? ((s = "slideTo"), (n = i.carouselPage))
          : void 0 !== i.carouselNext
          ? (s = "slideNext")
          : void 0 !== i.carouselPrev && (s = "slidePrev")),
        s
          ? (t.preventDefault(),
            t.stopPropagation(),
            e && !e.hasAttribute("disabled") && this[s](n))
          : this.emit("click", t);
    }
    onSlideTo(t) {
      const e = t.detail || 0;
      this.slideTo(this.getPageForSlide(e), { friction: 0 });
    }
    onChange(t, e = 0) {
      const i = this.page;
      (this.prevPage = i),
        (this.page = t),
        this.option("adaptiveHeight") && this.setViewportHeight(),
        t !== i && (this.markSelectedSlides(), this.emit("change", t, i, e));
    }
    onRefresh() {
      let t = this.contentDim,
        e = this.viewportDim;
      this.updateMetrics(),
        (this.contentDim === t && this.viewportDim === e) ||
          this.slideTo(this.page, { friction: 0, transition: !1 });
    }
    onScroll() {
      var t;
      null === (t = this.viewport) || void 0 === t || t.scroll(0, 0);
    }
    onResize() {
      this.option("breakpoints") && this.processOptions();
    }
    onBeforeTransform(t) {
      this.lp !== t.current[this.axis] &&
        (this.flipInfiniteTrack(), this.manageSlideVisiblity()),
        (this.lp = t.current.e);
    }
    onEndAnimation() {
      this.inTransition.size || this.emit("settle");
    }
    reInit(t = null, e = null) {
      this.destroy(),
        (this.state = I.Init),
        (this.prevPage = null),
        (this.userOptions = t || this.userOptions),
        (this.userPlugins = e || this.userPlugins),
        this.processOptions();
    }
    slideTo(
      t = 0,
      {
        friction: e = this.option("friction"),
        transition: i = this.option("transition"),
      } = {}
    ) {
      if (this.state === I.Destroy) return;
      t = parseInt((t || 0).toString()) || 0;
      const n = this.getPageFromIndex(t),
        { axis: s, isHorizontal: o, isRTL: a, pages: r, panzoom: l } = this,
        h = r.length,
        c = a && o ? 1 : -1;
      if (!l || !h) return;
      if (this.page !== n) {
        const e = new Event("beforeChange", { bubbles: !0, cancelable: !0 });
        if ((this.emit("beforeChange", e, t), e.defaultPrevented)) return;
      }
      if (this.transitionTo(t, i)) return;
      let d = r[n].pos;
      if (this.isInfinite) {
        const e = this.contentDim,
          i = l.target[s] * c;
        if (2 === h) d += e * Math.floor(parseFloat(t + "") / 2);
        else {
          d = [d, d - e, d + e].reduce(function (t, e) {
            return Math.abs(e - i) < Math.abs(t - i) ? e : t;
          });
        }
      }
      (d *= c),
        Math.abs(l.target[s] - d) < 1 ||
          (l.panTo({ x: o ? d : 0, y: o ? 0 : d, friction: e }),
          this.onChange(n));
    }
    slideToClosest(t) {
      if (this.panzoom) {
        const { pageIndex: e } = this.getPageFromPosition();
        this.slideTo(e, t);
      }
    }
    slideNext() {
      this.slideTo(this.page + 1);
    }
    slidePrev() {
      this.slideTo(this.page - 1);
    }
    clearTransitions() {
      this.inTransition.clear(), P(this.container, this.cn("inTransition"));
      const t = ["to-prev", "to-next", "from-prev", "from-next"];
      for (const e of this.slides) {
        const i = e.el;
        if (i) {
          i.removeEventListener(G, this.onAnimationEnd),
            i.classList.remove(...t);
          const n = e.transition;
          n && i.classList.remove(`f-${n}Out`, `f-${n}In`);
        }
      }
      this.manageSlideVisiblity();
    }
    addSlide(t, e) {
      var i, n, s, o;
      const a = this.panzoom,
        r =
          (null === (i = this.pages[this.page]) || void 0 === i
            ? void 0
            : i.pos) || 0,
        l =
          (null === (n = this.pages[this.page]) || void 0 === n
            ? void 0
            : n.dim) || 0,
        h = this.contentDim < this.viewportDim;
      let c = Array.isArray(e) ? e : [e];
      const d = [];
      for (const t of c) d.push(B(t));
      this.slides.splice(t, 0, ...d);
      for (let t = 0; t < this.slides.length; t++) this.slides[t].index = t;
      for (const t of d) this.emit("beforeInitSlide", t, t.index);
      if (
        (this.page >= t && (this.page += d.length), this.updateMetrics(), a)
      ) {
        const e =
            (null === (s = this.pages[this.page]) || void 0 === s
              ? void 0
              : s.pos) || 0,
          i =
            (null === (o = this.pages[this.page]) || void 0 === o
              ? void 0
              : o.dim) || 0,
          n = this.pages.length || 1,
          c = this.isRTL ? l - i : i - l,
          d = this.isRTL ? r - e : e - r;
        h && 1 === n
          ? (t <= this.page &&
              ((a.current[this.axis] -= c), (a.target[this.axis] -= c)),
            a.panTo({ [this.isHorizontal ? "x" : "y"]: -1 * e }))
          : d &&
            t <= this.page &&
            ((a.target[this.axis] -= d),
            (a.current[this.axis] -= d),
            a.requestTick());
      }
      for (const t of d) this.emit("initSlide", t, t.index);
    }
    prependSlide(t) {
      this.addSlide(0, t);
    }
    appendSlide(t) {
      this.addSlide(this.slides.length, t);
    }
    removeSlide(t) {
      const e = this.slides.length;
      t = ((t % e) + e) % e;
      const i = this.slides[t];
      if (i) {
        this.removeSlideEl(i, !0), this.slides.splice(t, 1);
        for (let t = 0; t < this.slides.length; t++) this.slides[t].index = t;
        this.updateMetrics(),
          this.slideTo(this.page, { friction: 0, transition: !1 }),
          this.emit("destroySlide", i);
      }
    }
    updateMetrics() {
      const {
        panzoom: t,
        viewport: i,
        track: n,
        slides: s,
        isHorizontal: o,
        isInfinite: a,
      } = this;
      if (!n) return;
      const r = o ? "width" : "height",
        l = o ? "offsetWidth" : "offsetHeight";
      if (i) {
        let t = Math.max(i[l], e(i.getBoundingClientRect()[r], 1e3)),
          n = getComputedStyle(i),
          s = "padding",
          a = o ? "Right" : "Bottom";
        (t -= parseFloat(n[s + (o ? "Left" : "Top")]) + parseFloat(n[s + a])),
          (this.viewportDim = t);
      }
      let h,
        c = 0;
      for (const [t, i] of s.entries()) {
        let n = 0,
          o = 0;
        !i.el && h
          ? ((n = h.dim), (o = h.gap))
          : (({ dim: n, gap: o } = this.getSlideMetrics(i)), (h = i)),
          (n = e(n, 1e3)),
          (o = e(o, 1e3)),
          (i.dim = n),
          (i.gap = o),
          (i.pos = c),
          (c += n),
          (a || t < s.length - 1) && (c += o);
      }
      (c = e(c, 1e3)),
        (this.contentDim = c),
        t &&
          ((t.contentRect[r] = c),
          (t.contentRect[o ? "fullWidth" : "fullHeight"] = c)),
        (this.pages = this.createPages()),
        (this.pages = this.processPages()),
        this.state === I.Init && this.setInitialPage(),
        (this.page = Math.max(0, Math.min(this.page, this.pages.length - 1))),
        this.manageSlideVisiblity(),
        this.emit("refresh");
    }
    getProgress(t, i = !1, n = !1) {
      void 0 === t && (t = this.page);
      const s = this,
        o = s.panzoom,
        a = s.contentDim,
        r = s.pages[t] || 0;
      if (!r || !o) return t > this.page ? -1 : 1;
      let l = -1 * o.current.e,
        h = e((l - r.pos) / (1 * r.dim), 1e3),
        c = h,
        d = h;
      this.isInfinite &&
        !0 !== n &&
        ((c = e((l - r.pos + a) / (1 * r.dim), 1e3)),
        (d = e((l - r.pos - a) / (1 * r.dim), 1e3)));
      let u = [h, c, d].reduce(function (t, e) {
        return Math.abs(e) < Math.abs(t) ? e : t;
      });
      return i ? u : u > 1 ? 1 : u < -1 ? -1 : u;
    }
    setViewportHeight() {
      const { page: t, pages: e, viewport: i, isHorizontal: n } = this;
      if (!i || !e[t]) return;
      let s = 0;
      n &&
        this.track &&
        ((this.track.style.height = "auto"),
        e[t].slides.forEach((t) => {
          t.el && (s = Math.max(s, t.el.offsetHeight));
        })),
        (i.style.height = s ? `${s}px` : "");
    }
    getPageForSlide(t) {
      for (const e of this.pages)
        for (const i of e.slides) if (i.index === t) return e.index;
      return -1;
    }
    getVisibleSlides(t = 0) {
      var e;
      const i = new Set();
      let {
        panzoom: n,
        contentDim: s,
        viewportDim: o,
        pages: a,
        page: r,
      } = this;
      if (o) {
        s =
          s +
            (null === (e = this.slides[this.slides.length - 1]) || void 0 === e
              ? void 0
              : e.gap) || 0;
        let l = 0;
        (l =
          n && n.state !== m.Init && n.state !== m.Destroy
            ? -1 * n.current[this.axis]
            : (a[r] && a[r].pos) || 0),
          this.isInfinite && (l -= Math.floor(l / s) * s),
          this.isRTL && this.isHorizontal && (l *= -1);
        const h = l - o * t,
          c = l + o * (t + 1),
          d = this.isInfinite ? [-1, 0, 1] : [0];
        for (const t of this.slides)
          for (const e of d) {
            const n = t.pos + e * s,
              o = n + t.dim + t.gap;
            n < c && o > h && i.add(t);
          }
      }
      return i;
    }
    getPageFromPosition(t) {
      const {
          viewportDim: e,
          contentDim: i,
          slides: n,
          pages: s,
          panzoom: o,
        } = this,
        a = s.length,
        r = n.length,
        l = n[0],
        h = n[r - 1],
        c = this.option("center");
      let d = 0,
        u = 0,
        g = 0,
        f =
          void 0 === t
            ? -1 * ((null == o ? void 0 : o.target[this.axis]) || 0)
            : t;
      c && (f += 0.5 * e),
        this.isInfinite
          ? (f < l.pos - 0.5 * h.gap && ((f -= i), (g = -1)),
            f > h.pos + h.dim + 0.5 * h.gap && ((f -= i), (g = 1)))
          : (f = Math.max(l.pos || 0, Math.min(f, h.pos)));
      let p = h,
        m = n.find((t) => {
          const e = t.pos - 0.5 * p.gap,
            i = t.pos + t.dim + 0.5 * t.gap;
          return (p = t), f >= e && f < i;
        });
      return (
        m || (m = h),
        (u = this.getPageForSlide(m.index)),
        (d = u + g * a),
        { page: d, pageIndex: u }
      );
    }
    setPageFromPosition() {
      const { pageIndex: t } = this.getPageFromPosition();
      this.onChange(t);
    }
    destroy() {
      if ([I.Destroy].includes(this.state)) return;
      this.state = I.Destroy;
      const {
          container: t,
          viewport: e,
          track: i,
          slides: n,
          panzoom: s,
        } = this,
        o = this.option("classes");
      t.removeEventListener("click", this.onClick, {
        passive: !1,
        capture: !1,
      }),
        t.removeEventListener("slideTo", this.onSlideTo),
        window.removeEventListener("resize", this.onResize),
        s && (s.destroy(), (this.panzoom = null)),
        n &&
          n.forEach((t) => {
            this.removeSlideEl(t);
          }),
        this.detachPlugins(),
        e &&
          (e.removeEventListener("scroll", this.onScroll),
          e.offsetParent &&
            i &&
            i.offsetParent &&
            e.replaceWith(...i.childNodes));
      for (const [e, i] of Object.entries(o))
        "container" !== e && i && t.classList.remove(i);
      (this.track = null),
        (this.viewport = null),
        (this.page = 0),
        (this.slides = []);
      const a = this.events.get("ready");
      (this.events = new Map()), a && this.events.set("ready", a);
    }
  }
  Object.defineProperty(J, "Panzoom", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: R,
  }),
    Object.defineProperty(J, "defaults", {
      enumerable: !0,
      configurable: !0,
      writable: !0,
      value: F,
    }),
    Object.defineProperty(J, "Plugins", {
      enumerable: !0,
      configurable: !0,
      writable: !0,
      value: _,
    }),
    (t.Carousel = J),
    (t.Panzoom = R);
});

!(function (e, t) {
  "object" == typeof exports && "undefined" != typeof module
    ? t(exports)
    : "function" == typeof define && define.amd
    ? define(["exports"], t)
    : t(
        ((e =
          "undefined" != typeof globalThis ? globalThis : e || self).window =
          e.window || {})
      );
})(this, function (e) {
  "use strict";
  const t = (e, ...s) => {
      const n = s.length;
      for (let i = 0; i < n; i++) {
        const n = s[i] || {};
        Object.entries(n).forEach(([s, n]) => {
          const i = Array.isArray(n) ? [] : {};
          var o;
          e[s] || Object.assign(e, { [s]: i }),
            "object" == typeof (o = n) &&
            null !== o &&
            o.constructor === Object &&
            "[object Object]" === Object.prototype.toString.call(o)
              ? Object.assign(e[s], t(i, n))
              : Array.isArray(n)
              ? Object.assign(e, { [s]: [...n] })
              : Object.assign(e, { [s]: n });
        });
      }
      return e;
    },
    s = function (e, t) {
      return e
        .split(".")
        .reduce((e, t) => ("object" == typeof e ? e[t] : void 0), t);
    };
  class n {
    constructor(e = {}) {
      Object.defineProperty(this, "options", {
        enumerable: !0,
        configurable: !0,
        writable: !0,
        value: e,
      }),
        Object.defineProperty(this, "events", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: new Map(),
        }),
        this.setOptions(e);
      for (const e of Object.getOwnPropertyNames(Object.getPrototypeOf(this)))
        e.startsWith("on") &&
          "function" == typeof this[e] &&
          (this[e] = this[e].bind(this));
    }
    setOptions(e) {
      this.options = e ? t({}, this.constructor.defaults, e) : {};
      for (const [e, t] of Object.entries(this.option("on") || {}))
        this.on(e, t);
    }
    option(e, ...t) {
      let n = s(e, this.options);
      return n && "function" == typeof n && (n = n.call(this, this, ...t)), n;
    }
    optionFor(e, t, n, ...i) {
      let o = s(t, e);
      var r;
      "string" != typeof (r = o) ||
        isNaN(r) ||
        isNaN(parseFloat(r)) ||
        (o = parseFloat(o)),
        "true" === o && (o = !0),
        "false" === o && (o = !1),
        o && "function" == typeof o && (o = o.call(this, this, e, ...i));
      let a = s(t, this.options);
      return (
        a && "function" == typeof a
          ? (o = a.call(this, this, e, ...i, o))
          : void 0 === o && (o = a),
        void 0 === o ? n : o
      );
    }
    cn(e) {
      const t = this.options.classes;
      return (t && t[e]) || "";
    }
    localize(e, t = []) {
      e = String(e).replace(/\{\{(\w+).?(\w+)?\}\}/g, (e, t, s) => {
        let n = "";
        return (
          s
            ? (n = this.option(
                `${t[0] + t.toLowerCase().substring(1)}.l10n.${s}`
              ))
            : t && (n = this.option(`l10n.${t}`)),
          n || (n = e),
          n
        );
      });
      for (let s = 0; s < t.length; s++) e = e.split(t[s][0]).join(t[s][1]);
      return (e = e.replace(/\{\{(.*?)\}\}/g, (e, t) => t));
    }
    on(e, t) {
      let s = [];
      "string" == typeof e ? (s = e.split(" ")) : Array.isArray(e) && (s = e),
        this.events || (this.events = new Map()),
        s.forEach((e) => {
          let s = this.events.get(e);
          s || (this.events.set(e, []), (s = [])),
            s.includes(t) || s.push(t),
            this.events.set(e, s);
        });
    }
    off(e, t) {
      let s = [];
      "string" == typeof e ? (s = e.split(" ")) : Array.isArray(e) && (s = e),
        s.forEach((e) => {
          const s = this.events.get(e);
          if (Array.isArray(s)) {
            const e = s.indexOf(t);
            e > -1 && s.splice(e, 1);
          }
        });
    }
    emit(e, ...t) {
      [...(this.events.get(e) || [])].forEach((e) => e(this, ...t)),
        "*" !== e && this.emit("*", e, ...t);
    }
  }
  Object.defineProperty(n, "version", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: "5.0.36",
  }),
    Object.defineProperty(n, "defaults", {
      enumerable: !0,
      configurable: !0,
      writable: !0,
      value: {},
    });
  class i extends n {
    constructor(e, t) {
      super(t),
        Object.defineProperty(this, "instance", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: e,
        });
    }
    attach() {}
    detach() {}
  }
  const o = (e) => `${e || ""}`.split(" ").filter((e) => !!e),
    r = (e, t) => {
      e &&
        o(t).forEach((t) => {
          e.classList.add(t);
        });
    },
    a = "play",
    l = "pause",
    c = "ready";
  class u extends i {
    constructor() {
      super(...arguments),
        Object.defineProperty(this, "state", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: c,
        }),
        Object.defineProperty(this, "inHover", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: !1,
        }),
        Object.defineProperty(this, "timer", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        }),
        Object.defineProperty(this, "progressBar", {
          enumerable: !0,
          configurable: !0,
          writable: !0,
          value: null,
        });
    }
    get isActive() {
      return this.state !== c;
    }
    onReady(e) {
      this.option("autoStart") &&
        (e.isInfinite || e.page < e.pages.length - 1) &&
        this.start();
    }
    onChange() {
      this.removeProgressBar(), this.pause();
    }
    onSettle() {
      this.resume();
    }
    onVisibilityChange() {
      "visible" === document.visibilityState ? this.resume() : this.pause();
    }
    onMouseEnter() {
      (this.inHover = !0), this.pause();
    }
    onMouseLeave() {
      var e;
      (this.inHover = !1),
        (null === (e = this.instance.panzoom) || void 0 === e
          ? void 0
          : e.isResting) && this.resume();
    }
    onTimerEnd() {
      const e = this.instance;
      "play" === this.state &&
        (e.isInfinite || e.page !== e.pages.length - 1
          ? e.slideNext()
          : e.slideTo(0));
    }
    removeProgressBar() {
      this.progressBar &&
        (this.progressBar.remove(), (this.progressBar = null));
    }
    createProgressBar() {
      var e;
      if (!this.option("showProgress")) return null;
      this.removeProgressBar();
      const t = this.instance,
        s =
          (null === (e = t.pages[t.page]) || void 0 === e
            ? void 0
            : e.slides) || [];
      let n = this.option("progressParentEl");
      if ((n || (n = (1 === s.length ? s[0].el : null) || t.viewport), !n))
        return null;
      const i = document.createElement("div");
      return (
        r(i, "f-progress"),
        n.prepend(i),
        (this.progressBar = i),
        i.offsetHeight,
        i
      );
    }
    set() {
      const e = this,
        t = e.instance;
      if (t.pages.length < 2) return;
      if (e.timer) return;
      const s = e.option("timeout");
      (e.state = a), r(t.container, "has-autoplay");
      let n = e.createProgressBar();
      n &&
        ((n.style.transitionDuration = `${s}ms`),
        (n.style.transform = "scaleX(1)")),
        (e.timer = setTimeout(() => {
          (e.timer = null), e.inHover || e.onTimerEnd();
        }, s)),
        e.emit("set");
    }
    clear() {
      const e = this;
      e.timer && (clearTimeout(e.timer), (e.timer = null)),
        e.removeProgressBar();
    }
    start() {
      const e = this;
      if ((e.set(), e.state !== c)) {
        if (e.option("pauseOnHover")) {
          const t = e.instance.container;
          t.addEventListener("mouseenter", e.onMouseEnter, !1),
            t.addEventListener("mouseleave", e.onMouseLeave, !1);
        }
        document.addEventListener("visibilitychange", e.onVisibilityChange, !1),
          e.emit("start");
      }
    }
    stop() {
      const e = this,
        t = e.state,
        s = e.instance.container;
      var n, i;
      e.clear(),
        (e.state = c),
        s.removeEventListener("mouseenter", e.onMouseEnter, !1),
        s.removeEventListener("mouseleave", e.onMouseLeave, !1),
        document.removeEventListener(
          "visibilitychange",
          e.onVisibilityChange,
          !1
        ),
        (i = "has-autoplay"),
        (n = s) &&
          o(i).forEach((e) => {
            n.classList.remove(e);
          }),
        t !== c && e.emit("stop");
    }
    pause() {
      const e = this;
      e.state === a && ((e.state = l), e.clear(), e.emit(l));
    }
    resume() {
      const e = this,
        t = e.instance;
      if (t.isInfinite || t.page !== t.pages.length - 1)
        if (e.state !== a) {
          if (e.state === l && !e.inHover) {
            const t = new Event("resume", { bubbles: !0, cancelable: !0 });
            e.emit("resume", t), t.defaultPrevented || e.set();
          }
        } else e.set();
      else e.stop();
    }
    toggle() {
      this.state === a || this.state === l ? this.stop() : this.start();
    }
    attach() {
      const e = this,
        t = e.instance;
      t.on("ready", e.onReady),
        t.on("Panzoom.startAnimation", e.onChange),
        t.on("Panzoom.endAnimation", e.onSettle),
        t.on("Panzoom.touchMove", e.onChange);
    }
    detach() {
      const e = this,
        t = e.instance;
      t.off("ready", e.onReady),
        t.off("Panzoom.startAnimation", e.onChange),
        t.off("Panzoom.endAnimation", e.onSettle),
        t.off("Panzoom.touchMove", e.onChange),
        e.stop();
    }
  }
  Object.defineProperty(u, "defaults", {
    enumerable: !0,
    configurable: !0,
    writable: !0,
    value: {
      autoStart: !0,
      pauseOnHover: !0,
      progressParentEl: null,
      showProgress: !0,
      timeout: 3e3,
    },
  }),
    (e.Autoplay = u);
});
