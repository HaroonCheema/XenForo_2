!function(){"use strict";!function(t,e,a){XF.RtcAvatarBox=XF.Element.newHandler({options:{},fileReader:null,roomAvatarHtml:"",init(){this.$avatar=this.$target.find(".rtc-room-avatar"),this.roomAvatarHtml=this.$avatar.html(),this.fileReader=new FileReader,this.fileReader.addEventListener("load",(()=>{this._updateAvatar(this.fileReader.result)})),this.$uploadInput=this.$target.find('input[type="file"]'),this.$uploadInput.on("change",XF.proxy(this,"fileChanged"))},fileChanged(){const t=this.$uploadInput[0].files[0];t?this.fileReader.readAsDataURL(t):this.restoreAvatar()},restoreAvatar(){this.$avatar.html(this.roomAvatarHtml)},_updateAvatar(t){this.$avatar.html(`<img src="${t}" alt="Room Avatar" />`)}}),XF.ElementValueSetter=XF.Click.newHandler({eventNameSpace:"XFElementValueSetter",options:{value:null,selector:null},init(){this.$input=XF.findRelativeIf(this.options.selector,this.$target)},click(){if(this.$input.is(":checkbox")){const t="boolean"==typeof this.options.value?this.options.value:!this.$input.prop("checked");this.$input.prop("checked",t)}else this.$input.val(this.options.value)}}),t(a).on("ajax-submit:complete",'[data-xf-init*="ajax-submit"][data-clear-complete]',((e,a)=>{"ok"===a.status&&t(e.target).clear()})),XF.Element.register("rtc-avatar-box","XF.RtcAvatarBox"),XF.Click.register("element-value-setter","XF.ElementValueSetter")}(window.jQuery,window,document)}();