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
var AddonsLab = AddonsLab || {};
!function ($, window, document, _undefined) {
    "use strict";
    AddonsLab.MultipleChoiceConfigure = XF.Element.newHandler({
        init: function () {
            var $configurationContainer = this.$target;
            var $inputContainer = $configurationContainer.prev();
            var $select = $inputContainer.find('select');
            if ($select.length) {
                var updateSelect = function () {
                    var selectedOptions = $select.val();
                    selectedOptions = $.grep(selectedOptions, function (elem) {
                        return elem !== '';
                    });
                    if (selectedOptions.length > 1) {
                        $configurationContainer.show();
                    } else {
                        $configurationContainer.hide();
                    }
                };

                $select.change(updateSelect);
                updateSelect();
            }


            var $allCheckboxes = $inputContainer.find('input[type=checkbox]');
            if($allCheckboxes.length) {
                var updateCheckboxes = function () {
                    if ($allCheckboxes.filter(':checked').length > 1) {
                        $configurationContainer.show();
                    } else {
                        $configurationContainer.hide();
                    }
                };

                $allCheckboxes.change(updateCheckboxes);
                updateCheckboxes();
            }
        }
    });

    XF.Element.register('multipleChoiceConfigure', 'AddonsLab.MultipleChoiceConfigure');
}(jQuery, window, document);
