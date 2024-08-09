/**
 * Modified version from https://github.com/vijitail/Kel
 */
const Kel = (function () {
    function deepFreeze(o) {
        Object.freeze(o);
        Object.keys(o).forEach((key) => {
            if (
                o.hasOwnProperty(key) &&
                o[key] !== null &&
                (typeof o[key] === "object" || typeof o[key] === "function") &&
                !Object.isFrozen(o[key])
            ) {
                deepFreeze(o[key]);
            }
        });

        return o;
    }

    let store = {};

    const events = {};

    function KelConstructor(initialStore = {}) {
        store = initialStore;
    }

    KelConstructor.prototype.getStore = function () {
        return store;
    }

    KelConstructor.prototype.emit = function (eventName, payload) {
        if (typeof payload == "function") payload = payload(deepFreeze(store));

        if (payload !== undefined && Object.prototype.toString.call(payload) !== "[object Object]") {
            console.error("Payload should be an object");
            return false;
        }

        let hasUpdated = false;

        if (payload !== undefined) {
            store = {...store, ...payload};
            hasUpdated = true;
        }

        if (hasUpdated) {
            this.emit('__EVENT_STORE_UPDATED');
        }

        if (!events.hasOwnProperty(eventName)) {
            // No handler is registered for this event
            return false;
        }

        events[eventName].forEach(({dep, cb}) => {
            if (dep.length == 0) cb(deepFreeze(store));
            else {
                const t = {};
                dep.forEach((k) => {
                    if (store.hasOwnProperty(k)) t[k] = store[k];
                });
                cb(t);
            }
        });

        return true;
    };

    KelConstructor.prototype.on = function (eventName, cb, dep = []) {
        if (typeof cb !== "function") {
            console.error("on() method expects 2nd argument as a callback function");
            return false;
        }

        if (Object.prototype.toString.call(dep) !== "[object Array]") {
            console.error("on() method expects 3nd argument as an array");
            return false;
        }

        if (!events.hasOwnProperty(eventName)) events[eventName] = [];

        events[eventName].push({dep, cb});

        return true;
    };

    return KelConstructor;
})();