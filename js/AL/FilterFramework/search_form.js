/** 
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/
!function ($, window, document, _undefined) {
    "use strict";

    var $filterContainer = $('#itemFilterContainer');
    var apiUrl = $filterContainer.data('api');
    var $containerForm = $filterContainer.closest('form');

    var lastFormData = false;

    function loadFilterFields() {
        var formData = $containerForm.serializeArray();
        if (lastFormData === false) {
            // the first submission
            // take the data in URL
            lastFormData = convertObjectToFormParams($filterContainer.data('preload'));
            // merge it into form data overwriting it
            formData = mergeData(lastFormData, formData, true);
            // keep the merged version as latest data
            lastFormData = formData;
        } else {
            // make sure the data that existed the last time is merged into the current, no overwrite of current
            formData = mergeData(formData, lastFormData, false);

            // merge the data from this submission in the last state, overwrite the existing
            lastFormData = mergeData(lastFormData, formData, true);
        }

        XF.ajax('get', apiUrl, formData, function (data) {
            if (data.html && data.html.content) {
                XF.setupHtmlInsert(data.html, function ($html, data) {
                    $filterContainer.html($html);
                    XF.activate($filterContainer);
                    XF.layoutChange();
                });
            } else {
                $filterContainer.html('');
                XF.layoutChange();
            }
        });
    }

    function convertObjectToFormParams(obj) {
        var string = $.param(obj);

        var formParams = [];
        string.split("&").map(function (value) {
            var pair = value.split('=');
            formParams.push({
                name: decodeURI(pair[ 0 ]),
                value: decodeURI(pair[ 1 ])
            })
        });

        return formParams;
    }

    /**
     * Merged state2 into state1
     * @param state1 array
     * @param state2 array
     * @param overwrite bool
     */
    function mergeData(state1, state2, overwrite) {
        // any key will be processed only once
        var processedKeys = [];

        for (var i = 0; i < state2.length; i++) {
            var stateKey = state2[ i ].name

            if (processedKeys.indexOf(stateKey) > -1) {
                // this name was already processed
                continue;
            }

            // get all data from state2 with this key
            var state2Data = getStatesByKey(state2, stateKey);

            // see if we have arrays in state1 with that key
            var state1Data = getStatesByKey(state1, stateKey);

            if (state1Data.length === 0) {
                // this field is not found in the state1 at all, add them to it
                state1 = $.merge(state1, state2Data);
            } else if (overwrite) {
                // delete all data from state1 having this key
                state1 = deleteStatesByKey(state1, stateKey);
                // merge it with state2 data
                state1 = $.merge(state1, state2Data);
            }

            processedKeys.push(state2.name);
        }

        return state1;
    }

    function deleteStatesByKey(state, stateKey) {
        var newState = [];
        for (var i = 0; i < state.length; i++) {
            if (state[ i ].name !== stateKey) {
                newState.push(state[ i ]);
            }
        }

        return newState;
    }

    function getStatesByKey(state, stateKey) {
        var states = [];
        for (var i = 0; i < state.length; i++) {
            if (state[ i ].name === stateKey) {
                states[ states.length ] = state[ i ];
            }
        }

        return states;
    }

    $(loadFilterFields); // run on load
    $containerForm.find('select').change(loadFilterFields);

    // Production steps of ECMA-262, Edition 5, 15.4.4.19
    // Reference: http://es5.github.com/#x15.4.4.19
    if (!Array.prototype.map) {
        Array.prototype.map = function (callback, thisArg) {

            var T, A, k;

            if (this == null) {
                throw new TypeError(" this is null or not defined");
            }

            // 1. Let O be the result of calling ToObject passing the |this| value as the argument.
            var O = Object(this);

            // 2. Let lenValue be the result of calling the Get internal method of O with the argument "length".
            // 3. Let len be ToUint32(lenValue).
            var len = O.length >>> 0;

            // 4. If IsCallable(callback) is false, throw a TypeError exception.
            // See: http://es5.github.com/#x9.11
            if (typeof callback !== "function") {
                throw new TypeError(callback + " is not a function");
            }

            // 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
            if (thisArg) {
                T = thisArg;
            }

            // 6. Let A be a new array created as if by the expression new Array(len) where Array is
            // the standard built-in constructor with that name and len is the value of len.
            A = new Array(len);

            // 7. Let k be 0
            k = 0;

            // 8. Repeat, while k < len
            while (k < len) {

                var kValue, mappedValue;

                // a. Let Pk be ToString(k).
                //   This is implicit for LHS operands of the in operator
                // b. Let kPresent be the result of calling the HasProperty internal method of O with argument Pk.
                //   This step can be combined with c
                // c. If kPresent is true, then
                if (k in O) {

                    // i. Let kValue be the result of calling the Get internal method of O with argument Pk.
                    kValue = O[ k ];

                    // ii. Let mappedValue be the result of calling the Call internal method of callback
                    // with T as the this value and argument list containing kValue, k, and O.
                    mappedValue = callback.call(T, kValue, k, O);

                    // iii. Call the DefineOwnProperty internal method of A with arguments
                    // Pk, Property Descriptor {Value: mappedValue, : true, Enumerable: true, Configurable: true},
                    // and false.

                    // In browsers that support Object.defineProperty, use the following:
                    // Object.defineProperty(A, Pk, { value: mappedValue, writable: true, enumerable: true, configurable: true });

                    // For best browser support, use the following:
                    A[ k ] = mappedValue;
                }
                // d. Increase k by 1.
                k++;
            }

            // 9. return A
            return A;
        };
    }
}(jQuery, window, document);