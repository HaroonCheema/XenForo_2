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

    AddonsLab.FilterFormColumnFix = XF.Element.newHandler({
        $columns: null,

        init: function () {
            if (this.$target.closest('.offCanvasMenu').length) {
                return;
            }

            var $form = this.$target.closest('form');
            this.$columns = $form.find('>.menu-row');
            // $(window).on('resize', XF.proxy(this.assignTopColumn, this));
            var assignTopColumn = XF.proxy(this.assignTopColumn, this);

            var redrawTrigger = null;

            $(window).on('resize', function () {
                if (redrawTrigger) {
                    redrawTrigger.cancel();
                }
                redrawTrigger = XF.requestAnimationTimeout(function () {
                    assignTopColumn();
                }, 300);
            });
            setTimeout(function () {
                assignTopColumn();
                setTimeout(function () {
                    assignTopColumn();
                }, 500);
            }, 100);
        },
        assignTopColumn: function () {
            this.$columns.removeClass('column--start');
            var left = 0;
            this.$columns.each(function (index, el) {
                var elementLeft = $(el).position().left;
                if (elementLeft > left) {
                    $(el).addClass('column--start');
                    left = elementLeft;
                }
            });
        }
    });

    XF.Element.register('filter-form-column-fix', 'AddonsLab.FilterFormColumnFix');
}(jQuery, window, document);
