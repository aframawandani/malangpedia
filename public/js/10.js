(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{"+SZM":function(t,a,e){"use strict";var s=e("vDqi"),n=e.n(s),i={store:e("Jc6O").a,data:function(){return{isGettingUser:!0,user:null,shopping_cart_products:[]}},mounted:function(){var t=this;this.$store.commit("refreshShoppingCartProducts"),$(".loader").fadeOut(),$("#preloder").delay(200).fadeOut("slow"),n.a.get("/api/auth/user").then((function(a){if(a.data instanceof Object){var e=a.data.data;e instanceof Object&&(t.user=e)}})).finally((function(){t.isGettingUser=!1}))}},r=(e("vGEg"),e("KHd+")),o=Object(r.a)(i,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[t._m(0),t._v(" "),e("header",{staticClass:"header"},[e("div",{staticClass:"container-fluid"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col flex-grow-0"},[e("div",{staticClass:"header__logo"},[e("inertia-link",{attrs:{href:"/"}},[e("h1",[t._v("MalangPedia")])])],1)]),t._v(" "),e("div",{staticClass:"col"},[e("nav",{staticClass:"header__menu"},[e("ul",[e("li",{staticClass:"active"},[e("inertia-link",{attrs:{href:"/"}},[t._v("Home")])],1),t._v(" "),e("li",[e("inertia-link",{attrs:{href:"/category/komputer-laptop/komputer-desktop"}},[t._v("Komputer Desktop")])],1),t._v(" "),e("li",[e("inertia-link",{attrs:{href:"/category/komputer-laptop/laptop"}},[t._v("Laptop")])],1),t._v(" "),e("li",[e("inertia-link",{attrs:{href:"/category/komputer-laptop/komponen"}},[t._v("Komponen")])],1),t._v(" "),e("li",[e("inertia-link",{attrs:{href:"/category/komputer-laptop/sewa-laptop"}},[t._v("Sewa Laptop")])],1)])])]),t._v(" "),e("div",{staticClass:"col flex-grow-0"},[t.isGettingUser?t._e():e("div",{staticClass:"header__right"},[t.user instanceof Object?e("div",{staticClass:"header__right__widget"},[e("li",[e("div",{staticClass:"dropdown",attrs:{id:"shoppingCartProductsDropdown"}},[e("inertia-link",{staticClass:"shopping-cart",attrs:{id:"shoppingCartDropdownLink",href:"/shopping-cart"}},[e("i",{staticClass:"feather icon-shopping-cart"}),t._v(" "),e("div",{staticClass:"tip"},[t._v(t._s(t.$store.state.shoppingCartProducts.length))])])],1)])]):t._e(),t._v(" "),e("div",{staticClass:"header__right__auth"},[t.user instanceof Object?t._e():e("inertia-link",{attrs:{href:"/auth/login"}},[t._v("Login")]),t._v(" "),t.user instanceof Object?t._e():e("inertia-link",{attrs:{href:"/auth/register"}},[t._v("Register")]),t._v(" "),t.user instanceof Object?e("inertia-link",{attrs:{href:"/profile"}},[t._v(t._s(t.user.name))]):t._e()],1)])])]),t._v(" "),t._m(1)])]),t._v(" "),t._t("default")],2)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{attrs:{id:"preloder"}},[a("div",{staticClass:"loader"})])},function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"canvas__open"},[a("i",{staticClass:"fa fa-bars"})])}],!1,null,null,null);a.a=o.exports},"5xnn":function(t,a,e){var s=e("VduA");"string"==typeof s&&(s=[[t.i,s,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(s,n);s.locals&&(t.exports=s.locals)},AYES:function(t,a,e){"use strict";e.r(a);var s=e("+SZM"),n=e("sk58"),i={metaInfo:{title:"Reports"},data:function(){return{data:[]}},layout:s.a,mounted:function(){var t=this;fetch("/api/category",{Accept:"application/json","Content-Type":"application/json"}).then((function(t){return t.json()})).then((function(a){t.data=a.data}))},components:{InsertForm:n.default}},r=e("KHd+"),o=Object(r.a)(i,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("h1",{staticClass:"mb-6 text-lg"},[t._v("Category")]),t._v(" "),e("div",{staticClass:"lg:flex mb-4 -mx-3"},[e("div",{staticClass:"lg:w-1/2 px-3"},[e("div",{staticClass:"bg-white rounded shadow overflow-x-auto p-4"},[e("insert-form")],1)]),t._v(" "),e("div",{staticClass:"mt-6 lg:mt-0 lg:w-1/2 px-3"},[e("div",{staticClass:"bg-white rounded shadow overflow-x-auto"},[e("table",{staticClass:"whitespace-no-wrap w-full"},[t._m(0),t._v(" "),e("tbody",[t._l(t.data,(function(a,s){return e("tr",{key:s,staticClass:"border-t"},[e("td",{staticClass:"p-3 text-sm"},[t._v(t._s(s+1))]),t._v(" "),e("td",{staticClass:"p-3 text-sm"},[t._v(t._s(a.name))]),t._v(" "),e("td")])})),t._v(" "),e("tr",{directives:[{name:"show",rawName:"v-show",value:0===t.data.length,expression:"data.length === 0"}],staticClass:"border-t"},[e("td",{staticClass:"p-3 text-sm text-center text-gray-600",attrs:{colspan:"3"}},[t._v("Kosong")])])],2)])])])])])}),[function(){var t=this.$createElement,a=this._self._c||t;return a("thead",[a("tr",{staticClass:"text-left font-bold"},[a("th",{staticClass:"font-semibold p-3 text-sm",staticStyle:{"min-width":"36px",width:"36px"}},[this._v("#")]),this._v(" "),a("th",{staticClass:"font-semibold p-3 text-sm",staticStyle:{width:"240px"}},[this._v("Nama")]),this._v(" "),a("th",{staticStyle:{width:"100%"}})])])}],!1,null,null,null);a.default=o.exports},Jc6O:function(t,a,e){"use strict";var s,n=e("Kw5r"),i=e("L2JU"),r=e("vDqi"),o=e.n(r),c=e("Wz0r");n.default.use(i.a);var l=new i.a.Store({state:{shoppingCartProducts:[]},mutations:{refreshShoppingCartProducts:function(t){o.a.get("/api/shopping-cart-product").then((function(a){if(a.data instanceof Object){var e=a.data.data;e instanceof Array&&(t.shoppingCartProducts=e)}}))},insertShoppingCartProduct:function(t,a){var e=a.product_id,s=a.quantity;o()({method:"POST",url:"/api/shopping-cart-product",data:{_method:"PUT",product_id:e,quantity:s}}).then((function(a){if(a.data instanceof Object){var e=a.data.data;e instanceof Object&&(201===a.status?t.shoppingCartProducts.push(e):200===a.status&&(t.shoppingCartProducts[idx].quantity=e.quantity))}})).catch((function(t){401===t.response.status&&c.Inertia.visit("/auth/login")}))},updateQuantityShoppingCartProduct:function(t,a){var e=a.idx,n=a.quantity;s instanceof Object&&s.cancel(),s=o.a.CancelToken.source();var i=t.shoppingCartProducts[e].product_id;t.shoppingCartProducts[e].quantity=n,o()({method:"POST",url:"/api/shopping-cart-product",data:{_method:"PATCH",product_id:i,quantity:n},cancelToken:s.token}).then((function(a){a.data instanceof Object&&a.data.data instanceof Object&&"number"==typeof a.data.data.quantity&&(t.shoppingCartProducts[e].quantity=a.data.data.quantity)})).catch((function(t){t.response instanceof Object&&401===t.response.status&&c.Inertia.visit("/auth/login")}))},increaseQuantityShoppingCartProduct:function(t,a){var e=a.idx,s=t.shoppingCartProducts[e].quantity;s++,this.commit("updateQuantityShoppingCartProduct",{idx:e,quantity:s})},decreaseQuantityShoppingCartProduct:function(t,a){var e=a.idx,s=t.shoppingCartProducts[e].quantity;s>1&&(s--,this.commit("updateQuantityShoppingCartProduct",{idx:e,quantity:s}))},removeShoppingCartProduct:function(t,a){var e=a.idx,s=t.shoppingCartProducts[e].product_id;o()({method:"POST",url:"/api/shopping-cart-product",data:{_method:"DELETE",product_id:[s]}}).then((function(a){t.shoppingCartProducts.splice(e,1)})).catch((function(t){401===t.response.status&&c.Inertia.visit("/auth/login")}))}}});a.a=l},VduA:function(t,a,e){(t.exports=e("I1BE")(!1)).push([t.i,"\n.dropdown-menu {\r\n  overflow: hidden;\n}\n#shoppingCartProductsDropdownMenu {\r\n  left: auto;\r\n  right: 0;\n}\r\n",""])},sk58:function(t,a,e){"use strict";e.r(a);var s=e("iVi/"),n=(e.n(s).a.parse(document.cookie),e("vDqi")),i=e.n(n),r=e("CjXH"),o={info:!0,success:!0,warning:!0,danger:!0},c={info:"bg-gray-200 text-gray-700",success:"bg-green-200 text-green-700",warning:"bg-yellow-200 text-yellow-700",danger:"bg-red-200 text-red-700"},l={data:function(){return{isLoading:!1,errors:{},messages:[{content:"Test 1",type:"danger",colorClasses:c.danger},{content:"Test 2",type:"success",colorClasses:c.success}]}},props:[],methods:{submit:function(t){var a=this,e=new FormData(t.target),s={};this.isLoading=!0,this.messages.length=0,this.errors={},e.forEach((function(t,a){s[a]=t})),i.a.put("/api/category",s,{headers:{Accept:"application/json","Content-Type":"application/json"}}).then((function(t){200===t.status?getData():"function"==typeof t.json&&t.json().then((function(t){a.errors=t.errors}))})).catch((function(t){var e=t.response.data;e instanceof Object&&(a.addMessage(e.message,"danger"),a.errors=e.errors)})).finally((function(){a.isLoading=!1}))},addMessage:function(t,a,e){var s={content:"",type:"info",colorClasses:c.info};"string"==typeof t&&(s.content=t),"string"==typeof a&&a in o&&(s.type=a,s.colorClasses=c[a]),"number"==typeof e&&Number.isFinite(e)?this.messages.splice(e,0,s):this.messages.push(s)},removeMessage:function(t){this.messages.splice(t,1)},getColorClasses:function(t){return"string"==typeof t&&t in c?c[t]:c.info}},components:{XIcon:r.a}},u=e("KHd+"),p=Object(u.a)(l,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[t._l(t.messages,(function(a,s){return e("div",{key:s,class:a.colorClasses+" rounded text-sm mb-4 pl-4 pr-10 py-2 relative",attrs:{role:"alert"}},[e("span",{staticClass:"inline-block leading-5"},[t._v(t._s(a.content))]),t._v(" "),e("button",{staticClass:"absolute top-0 p-2",staticStyle:{right:"8px",top:"2px"},on:{click:function(a){return t.removeMessage(s)}}},[e("x-icon",{attrs:{size:"16"}})],1)])})),t._v(" "),e("form",{on:{submit:function(a){return a.preventDefault(),t.submit(a)}}},[e("div",[e("label",{staticClass:"inline-block text-sm leading-5 text-gray-700 mb-1",attrs:{for:"nameInput"}},[t._v("Nama")]),t._v(" "),e("input",{staticClass:"form-input block text-sm leading-5 w-full sm:text-sm sm:leading-5",attrs:{id:"nameInput",name:"name",spellcheck:"false",autocomplete:"off"}}),t._v(" "),t._l(t.errors.name instanceof Array?t.errors.name:[],(function(a,s){return e("span",{key:s,staticClass:"inline-block text-red-500 text-sm mt-1"},[t._v(t._s(a))])}))],2),t._v(" "),e("div",{staticClass:"mt-4"},[e("label",{staticClass:"inline-block text-sm leading-5 text-gray-700 mb-1",attrs:{for:"slugInput"}},[t._v("Slug")]),t._v(" "),e("input",{staticClass:"form-input block text-sm leading-5 w-full sm:text-sm sm:leading-5",attrs:{id:"slugInput",name:"slug",spellcheck:"false",autocomplete:"off"}}),t._v(" "),t._l(t.errors.slug instanceof Array?t.errors.name:[],(function(a,s){return e("span",{key:s,staticClass:"inline-block text-red-500 text-sm mt-1"},[t._v(t._s(a))])}))],2),t._v(" "),t._m(0),t._v(" "),e("div",{staticClass:"mt-4"},[e("button",{staticClass:"bg-purple-500 hover:bg-purple-700 text-white text-sm p-3 rounded"},[t._v(t._s(t.isLoading?"Menambah...":"Tambah"))])])])],2)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"mt-4"},[a("label",{staticClass:"inline-block text-sm leading-5 text-gray-700 mb-1",attrs:{for:"descriptionTextarea"}},[this._v("Deskripsi")]),this._v(" "),a("textarea",{staticClass:"form-input block text-sm leading-4 w-full sm:text-sm sm:leading-5",attrs:{id:"descriptionTextarea",name:"description",spellcheck:"false",rows:"4"}})])}],!1,null,null,null);a.default=p.exports},vGEg:function(t,a,e){"use strict";var s=e("5xnn");e.n(s).a}}]);
//# sourceMappingURL=10.js.map?id=c77435ec5f41deb7a8fe