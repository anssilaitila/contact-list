!function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(t,n,e){i.o(t,n)||Object.defineProperty(t,n,{enumerable:!0,get:e})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,n){if(1&n&&(t=i(t)),8&n)return t;if(4&n&&"object"==typeof t&&t&&t.__esModule)return t;var e=Object.create(null);if(i.r(e),Object.defineProperty(e,"default",{enumerable:!0,value:t}),2&n&&"string"!=typeof t)for(var o in t)i.d(e,o,function(n){return t[n]}.bind(null,o));return e},i.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(n,"a",n),n},i.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},i.p="",i(i.s=11)}([,,,,,,,,,,,function(t,n,i){"use strict";i.r(n);i(12),i(13),i(14),i(15),i(16),i(17),i(18),i(19),i(20),i(21),i(22)},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n,i){},function(t,n){jQuery((function(t){if(jQuery(document).on("mouseover",".contact-list-copy",(function(t){if(void 0===n){var n=new ClipboardJS(".contact-list-copy");n.on("success",(function(t){t.clearSelection();var n=jQuery(t.trigger).data("clipboard-target");jQuery(n).tipso({content:"Shortcode copied to clipboard!",width:240}),jQuery(n).tipso("show"),setTimeout((function(){!function(t){jQuery(t).tipso("hide"),jQuery(t).tipso("destroy")}(n)}),2e3)})),n.on("error",(function(t){}))}})),jQuery(document).on("click",".contact-list-copy",(function(t){t.preventDefault()})),t(".contact-list-settings-tabs li").on("click",(function(n){var i=t(this).data("settings-container");t(".contact-list-settings-tabs li").removeClass("active"),t(".contact-list-settings-tab-1").hide(),t(".contact-list-settings-tab-2").hide(),t(".contact-list-settings-tab-3").hide(),t(".contact-list-settings-tab-4").hide(),t(".contact-list-settings-tab-5").hide(),t(".contact-list-settings-tab-6").hide(),t(".contact-list-settings-tab-7").hide(),t(".contact-list-settings-tab-8").hide(),t(".contact-list-settings-tab-9").hide(),t(".contact-list-settings-tab-10").hide(),t(this).addClass("active"),t("."+i).show(),window.history.pushState("","","#"+i),t(".contact-list-settings-form").attr("action","options.php#"+i)})),window.location.hash&&~window.location.hash.indexOf("contact-list-settings-tab")){var n=window.location.hash.substr(1);t(".contact-list-settings-tabs li").removeClass("active"),t(".contact-list-settings-tab-1").hide(),t(".contact-list-settings-tab-2").hide(),t(".contact-list-settings-tab-3").hide(),t(".contact-list-settings-tab-4").hide(),t(".contact-list-settings-tab-5").hide(),t(".contact-list-settings-tab-6").hide(),t(".contact-list-settings-tab-7").hide(),t(".contact-list-settings-tab-8").hide(),t(".contact-list-settings-tab-9").hide(),t(".contact-list-settings-tab-10").hide(),t("."+n+"-title").addClass("active"),t("."+n).show(),t(".contact-list-settings-form").attr("action","options.php#"+n)}else t(".contact-list-settings-tab-1-title").addClass("active");t('.wp-list-table tr[data-slug="contact-list"] .plugin-version-author-uri a:first-of-type').attr("target","_blank")}))}]);