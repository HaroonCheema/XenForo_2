!function(){"use strict";var s;s=window.jQuery,XF.MessengerRoomsSearch=XF.Element.newHandler({options:{searchUrl:""},loading:!1,searchType:"conversations",lastSearchQuery:"",init(){const s=this.$target.closest(".left-column");this.$chat=this.$target.rtc(),this.chat=this.$chat.rtc(!0),this.chat||this.$chat.on("chat:init",(()=>{this.chat=this.$chat.rtc(!0)})),this.$box=this.$target.closest(".js-searchBox"),this.$filters=this.$box.find(".js-searchFilters"),this.$container=s.find(".js-searchContainer"),this.$results=this.$container.find(".js-searchResults"),this.$loader=this.$container.find(".js-loader"),this.$target.on("focus",XF.proxy(this,"onFocus")),this.$container.on("click",".js-searchTab",XF.proxy(this,"onSearchTabClick")),this.$container.on("click",".js-roomResult",XF.proxy(this,"onRoomResultClick")),this.$container.on("click",".js-searchClose",XF.proxy(this,"onSearchCloseClick")),this.$box.on("click",".js-searchReset",XF.proxy(this,"onSearchResetClick")),this.$box.on("click",".js-searchClose",XF.proxy(this,"onSearchCloseClick")),this.$target.on("keydown paste",this._throttle((()=>{this.$target.val()&&!this.$box.hasClass("has-query")?this.$box.addClass("has-query"):!this.$target.val()&&this.$box.hasClass("has-query")&&this.$box.removeClass("has-query"),this.$target.val()!==this.lastSearchQuery&&this.loadSearchResults()}),400)),this.$filters.on("change",XF.proxy(this,"loadSearchResults"))},onFocus(){this.$box.addClass("is-active"),this.$container.addClass("is-active"),this.chat.rooms.$placeholder.removeClass("visible"),this.loadSearchResults()},onSearchTabClick(t){if(t.preventDefault(),this.loading)return;const e=s(t.currentTarget);this.setSearchType(e.data("type")),this.$container.find(".js-searchTab.is-active").removeClass("is-active"),e.addClass("is-active")},onRoomResultClick(t){t.preventDefault();const e=s(t.currentTarget),a=e.data("room-tag"),i=this.chat.$roomItems.find(`.js-room[data-room-tag="${a}"]`);i.length?this.chat.rooms.open(i):this.chat.rooms.open(e)},onSearchResetClick(s){s.preventDefault(),this.$target.val(""),this.$box.removeClass("has-query"),this.loadSearchResults()},onSearchCloseClick(s){s.preventDefault(),this.resetSearchForm()},setSearchType(s){this.searchType=s,this.loadSearchResults()},loadSearchResults(){if(this.loading)return;this.$results.html(""),this.loading=!0,this.$loader.addClass("is-active");const s=new FormData(this.$filters[0]);s.append("q",this.$target.val()),s.append("type",this.searchType),this.lastSearchQuery=s.get("q");const t={};for(const[e,a]of s.entries())t[e]=a;XF.ajax("GET",this.options.searchUrl,t,(({html:s})=>{XF.setupHtmlInsert(s,(s=>{this.$results.html(s)}))}),{global:!1}).always((()=>{this.loading=!1,this.$loader.removeClass("is-active")}))},resetSearchForm(){this.$filters[0].reset(),this.$target.val(""),this.$box.removeClass("is-active has-query"),this.$container.removeClass("is-active"),this.chat.rooms.updatePlaceholder()},_throttle(s,t){let e=null,a=0;return function(...i){const r=Date.now(),h=t-(r-a);h<=0||h>t?(e&&(clearTimeout(e),e=null),a=r,s.apply(this,i)):e||(e=setTimeout((()=>{a=Date.now(),e=null,s.apply(this,i)}),h))}}}),XF.Element.register("messenger-rooms-search","XF.MessengerRoomsSearch")}();