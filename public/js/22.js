(window.webpackJsonp=window.webpackJsonp||[]).push([[22],{AiNq:function(t,e,s){"use strict";s.r(e);var a=s("vDqi"),n=s.n(a),i={props:{onsuccessdelete:Function},data:function(){return{isDeleting:!1,data:{category_id:null,name:null}}},methods:{confirm:function(){var t=this;if(this.data.category_id){this.isDeleting=!0;var e={_method:"DELETE",category_id:this.data.category_id};n()({method:"POST",url:"/api/admin/category",data:e}).then((function(e){"function"==typeof t.onsuccessdelete&&t.onsuccessdelete.call(t,e)})).finally((function(){t.isDeleting=!1}))}}}},o=s("KHd+"),r=Object(o.a)(i,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal",attrs:{tabindex:"-1",role:"dialog"}},[s("div",{staticClass:"modal-dialog",attrs:{role:"document"}},[s("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),s("div",{staticClass:"modal-body"},[s("p",[t._v("Apakah Anda yakin akan menghapus kategori '"),s("strong",{domProps:{innerHTML:t._s(t.data.name)}}),t._v("'?")])]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:t.isDeleting},on:{click:t.confirm}},[t.isDeleting?s("i",{staticClass:"feather icon-loader"}):t._e(),t._v(" "),s("span",{staticClass:"text"},[t._v(t._s(t.isDeleting?"Menghapus...":"Ya"))])]),t._v(" "),s("button",{staticClass:"btn btn-default",attrs:{type:"button",disabled:t.isDeleting,"data-dismiss":"modal"}},[s("span",{staticClass:"text"},[t._v("Tidak")])])])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[e("span",{staticClass:"feather icon-x",attrs:{"aria-hidden":"true"}})]),this._v(" "),e("h4",{staticClass:"modal-title"},[this._v("Konfirmasi Hapus")])])}],!1,null,null,null);e.default=r.exports},"KHd+":function(t,e,s){"use strict";function a(t,e,s,a,n,i,o,r){var l,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=s,d._compiled=!0),a&&(d.functional=!0),i&&(d._scopeId="data-v-"+i),o?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},d._ssrRegister=l):n&&(l=r?function(){n.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,e){return l.call(e),c(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:d}}s.d(e,"a",(function(){return a}))}}]);
//# sourceMappingURL=22.js.map?id=c28ff54349f197d31689