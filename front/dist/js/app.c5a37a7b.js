(function(e){function t(t){for(var n,s,r=t[0],l=t[1],c=t[2],d=0,m=[];d<r.length;d++)s=r[d],Object.prototype.hasOwnProperty.call(i,s)&&i[s]&&m.push(i[s][0]),i[s]=0;for(n in l)Object.prototype.hasOwnProperty.call(l,n)&&(e[n]=l[n]);u&&u(t);while(m.length)m.shift()();return o.push.apply(o,c||[]),a()}function a(){for(var e,t=0;t<o.length;t++){for(var a=o[t],n=!0,r=1;r<a.length;r++){var l=a[r];0!==i[l]&&(n=!1)}n&&(o.splice(t--,1),e=s(s.s=a[0]))}return e}var n={},i={app:0},o=[];function s(t){if(n[t])return n[t].exports;var a=n[t]={i:t,l:!1,exports:{}};return e[t].call(a.exports,a,a.exports,s),a.l=!0,a.exports}s.m=e,s.c=n,s.d=function(e,t,a){s.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},s.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s.t=function(e,t){if(1&t&&(e=s(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(s.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)s.d(a,n,function(t){return e[t]}.bind(null,n));return a},s.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="./";var r=window["webpackJsonp"]=window["webpackJsonp"]||[],l=r.push.bind(r);r.push=t,r=r.slice();for(var c=0;c<r.length;c++)t(r[c]);var u=l;o.push([0,"chunk-vendors"]),a()})({0:function(e,t,a){e.exports=a("56d7")},"034f":function(e,t,a){"use strict";a("85ec")},"068e":function(e,t){e.exports="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAbCAYAAABvCO8sAAAC5ElEQVRIibWWPUxUQRSFv4V9ID9qAohaEBsSQmQVbIyJxp/CRhobC020sDMaY2WijY2FtDQmxsICY2eBFZWJhVphBKmMxmAQYzSKsAL7cy3m7DLv7ezyDPEkk8y77845M/feue9lzAwgB5wHngGvAQMyhFHWAGjSCKHCcRgYBR4DMxkJDktsDXgIrACtCYIMkAVm5IuIckBRAj7WgA7gsrhGgTeYGWaWM7NZS4dJM4s0JlOumZUGWe0mC7TXCU0See80+ZRr2qVRFfwOPAV2Az+AZpE2AzuAY0CffIsekT+fB14AS0AJl4IS0AV8lUZVcB64A+zBFUFB777hCuSBJ+gXkz9/BVzR+l3aTKT1i8CyL2hyuASc1stIpx4HVj1iv0rLnn0VF+JrwFltuhOYAu5KoyqIHD4Ah3ChBPioecnzW/eE1j17Sb7DwFHPdl/cJAWLwARwHLgoWz9wAxjy/A4A1715BUPy7fdsExobuda18MdJM1tUORfMbMXMil6Jl8xsWaPk2YvyLeh5UVwx/pBgZGZjKe9XI4yJK8Zf6TRJdOOKp9OPf0pEuKKbQlfBR8bMzgH7cBXWhCv1VcW9Xj/dDIarj22al3GX/1NWO7qFO03JW1Cu5fknVDYPrnqXgauVnN32kv0/UJBGlMXlaBzXZS7oZEXZgwlOgQwuclmddEIaBb9ouoATcsrjLvVWBFtweSsCz3E9um6VduDa3F7i3SQNWoAvwCPcdzWO5D3ROGNmS1vI2ZI4arjr/R4cJP33MYR2cdQgG7C1AgNsNPAkfgGzmg8BOwM+zeJoxf1qNBTsI96AfbwE7gHv9LwfuAkcCfj2i+t9zBqI8ykzWwjk5a2ZjQT8R/QuiQVxbZrDAaAnYSsAT4DpgP+03iV7bo+4YkgKtilMUcKeB+YCYhXMUftDFYmrrZFgNzAYIEzTAEI+g+KsIlk0vbhQ/AF+y9YC/KRxA1iXD57fdnH1Ap8rjn8BbIoBHoiObnEAAAAASUVORK5CYII="},"34c4":function(e,t,a){},3852:function(e,t,a){"use strict";a("cb72")},"469b":function(module,__webpack_exports__,__webpack_require__){"use strict";var core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_0__=__webpack_require__("a9e3"),core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_0___default=__webpack_require__.n(core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_0__);__webpack_exports__["a"]={props:["tableData","tableColumn","pagenum","pageno","total","showBatchDel","showExport","loading"],watch:{total:function(e){this.pagetotal=e},pagenum:function(e){this.pageNum=e},pageno:function(e){this.pageNo=e}},data:function(){return{pagetotal:0,pageNum:10,pageNo:0,selectRows:[]}},methods:{tableRowClassName:function(e){e.row;var t=e.rowIndex;return t%2==0?"rowlight":"rowdeep"},handleSelectionChange:function(e){this.selectRows=e},getEnterFiled:function(){var e=this.tableColumn[0].prop;return e},istrue:function istrue(condition,scope){return!condition||eval(condition)},isShow:function(){var e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];return e}},beforeUpdate:function(){var e=this;this.$nextTick((function(){e.$refs["table"]&&e.$refs["table"].doLayout()}))},filters:{filterData:function(e,t){return t.get(Number(e))?t.get(Number(e)):""}}}},"4db8":function(e,t,a){},"56d7":function(e,t,a){"use strict";a.r(t);a("e260"),a("e6cf"),a("cca6"),a("a79d");var n=a("2b0e"),i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{attrs:{id:"app"}},[a("main-tab-nav"),a("left-nav-bar"),a("div",{staticClass:"home"},[a("div",{staticClass:"dataview"},[a("router-view")],1)])],1)},o=[],s=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"maintabnav"},[e._m(0),a("div",{staticClass:"infobox"},[a("span",[e._v(e._s(e.date))]),a("span",[e._v(e._s(e.week))]),a("span",[e._v(e._s(e.time))]),a("span",{on:{mouseenter:function(t){e.isShowLogout=!0},mouseleave:function(t){e.isShowLogout=!1}}},[a("span",{staticClass:"showout",on:{click:function(t){e.isShowLogout=!e.isShowLogout}}},[a("span",[e._v(" 管理员")]),a("span",[e.isShowLogout?a("i",{staticClass:"el-icon-arrow-up"}):a("i",{staticClass:"el-icon-arrow-down"})])]),a("transition",{attrs:{name:"slide-fade"}},[e.isShowLogout?a("div",{staticClass:"logout",on:{click:e.logout}},[e._v("退出登录")]):e._e()])],1)])])},r=[function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"logo"},[n("img",{attrs:{src:a("068e"),alt:"",srcset:""}}),n("span",[e._v("一机游管理平台")])])}],l=(a("841c"),a("ac1f"),a("1276"),a("4d63"),a("25f0"),a("466d"),a("d3b7"),a("2f62"));n["default"].use(l["a"]);var c=new l["a"].Store({state:{token:"",login_status:!1,dataPrower:[],currentNav:{}},mutations:{setToken:function(e,t){e.token=t},setLoginStatus:function(e,t){e.login_status=t},setDataPrower:function(e,t){e.dataPrower=t},setcurrentNav:function(e,t){e.currentNav=t}},actions:{},getters:{}}),u=c,d=a("8c4f"),m=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("div",{staticClass:"overall"},[a("div",{staticClass:"ovearall_title"},[e._v("一机游整体情况")]),a("div",[a("el-row",{attrs:{gutter:20}},[a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("会员数量")]),a("div")])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("评论数量")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("咨询数量")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("投诉数量")])])])],1)],1)]),a("div",{staticClass:"overall"},[a("div",{staticClass:"ovearall_title"},[e._v("资源统计")]),a("div",[a("el-row",{attrs:{gutter:20}},[a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("会员数量")]),a("div",[e._v("1212")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("评论数量")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("咨询数量")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("投诉数量")])])])],1),a("el-row",{attrs:{gutter:20}},[a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("会员数量")]),a("div",[e._v("1212")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("评论数量")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("咨询数量")])])]),a("el-col",{attrs:{span:6,offset:0}},[a("div",{staticClass:"card"},[a("div",[e._v("投诉数量")])])])],1)],1)])])},f=[],p=(a("2b3d"),a("3ca3"),a("ddb0"),a("bc3a")),h=a.n(p);function v(e){var t=h.a.create({baseURL:"http://db.likezou.com:8080/cgi-bin",timeout:5e3});return t.interceptors.request.use((function(e){return e}),(function(e){})),t.interceptors.response.use((function(e){return e.data}),(function(e){})),t(e)}var b="/amobiletour_php/gthmmc/gthmmc/index.php?m=amobiletour&c=dataMange&a=";function g(e){return v({method:"get",url:b+"getResourcefield",params:e})}function _(e){return v({method:"get",url:b+"queryDataOfResource",params:e})}function w(e){return v({method:"post",url:b+"addDataOfResource",data:e})}function y(e){return v({method:"post",url:b+"modifyDataOfResource",data:e})}function x(e){return v({method:"get",url:b+"deleteDataOfResource",params:e})}function C(e){return v({method:"get",url:b+"deleteBatchData",params:e})}function k(e){return v({method:"get",url:b+"outputplanmodel",params:e,responseType:"arraybuffer"})}var D={methods:{outputplanmodel:function(){var e={data:{},directory_code:"play",pageNo:1,pageNum:10};k(e).then((function(e){var t=document.createElement("a"),a=new Blob([e],{type:"application/vnd.ms-excel"});t.style.display="none",t.href=URL.createObjectURL(a),t.download="测试",document.body.appendChild(t),t.click(),document.body.removeChild(t)})).catch((function(e){}))}}},N=D,E=(a("7a10"),a("2877")),A=Object(E["a"])(N,m,f,!1,null,"a8892154",null),O=A.exports,R=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("MainTabBar",{ref:"tabbar",attrs:{loading:e.showTabLoading,activename:e.activename,tabitem:e.tabitem},on:{handleTabClick:e.handleTabClick,closeTab:e.closeTab}},[a("div",{attrs:{slot:e.currentNav.name},slot:e.currentNav.name},[e.tableColumn.length?a("el-row",{staticClass:"row-bg top-box",attrs:{type:"flex",justify:"space-between"}},[a("el-col",{attrs:{span:6}},[a("el-button",{attrs:{size:"mini",type:"primary"},on:{click:e.handleAdd}},[e._v("新增")])],1),a("el-form",{attrs:{inline:!0},nativeOn:{submit:function(e){e.preventDefault()}}},[a("el-form-item",{attrs:{label:"名称："}},[a("el-input",{attrs:{size:"mini",clearable:""},nativeOn:{keyup:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.onQuery(t)}},model:{value:e.searchKey,callback:function(t){e.searchKey=t},expression:"searchKey"}})],1),a("el-form-item",[a("el-button",{attrs:{size:"mini",type:"primary",icon:"el-icon-search"},on:{click:e.onQuery}},[e._v("查询")])],1)],1)],1):e._e(),a("TableComp",{attrs:{"table-data":e.tableData,"table-column":e.tableColumn,pagenum:e.pageNum,total:e.pagetotal,pageno:e.pageNo,"show-batch-del":!0,"show-export":!1,loading:e.showTableLoading},on:{batchDel:e.batchDel,handlePageChange:e.handlePageChange,editRow:e.editRow,delRow:e.delRow}})],1),a("div",{attrs:{slot:e.tabEditLabel},slot:e.tabEditLabel},[a("FromData",{attrs:{"show-filed-data":e.showFieldData,selectdata:e.selectData,form:e.form,"is-edit":e.isEdit,rules:e.rules},on:{closetForm:e.closetForm,submitForm:e.submitForm}})],1)])],1)},$=[],L=a("ade3"),S=(a("b0c0"),a("4de4"),a("159b"),a("caad"),a("2532"),a("4ec9"),a("b64b"),a("d81d"),function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("el-tabs",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],attrs:{type:"border-card","element-loading-text":"拼命加载中"},on:{"tab-remove":e.removeTab,"tab-click":e.handleClick},model:{value:e.activeName,callback:function(t){e.activeName=t},expression:"activeName"}},e._l(e.tabitem,(function(t,n){return a("el-tab-pane",{key:n,attrs:{closable:t.closable,name:t.name,label:t.label}},[e._t(t.label)],2)})),1)],1)}),j=[],T=(a("a434"),{props:["tabitem","loading"],data:function(){return{activeName:this.tabitem[0].name}},methods:{handleClick:function(e,t){this.$emit("handleTabClick",e)},removeTab:function(e){var t=this;this.$emit("closeTab"),this.tabitem.forEach((function(a,n){a.name==e&&t.tabitem.splice(n,1)})),this.activeName=this.tabitem[0].name}}}),M=T,B=Object(E["a"])(M,S,j,!1,null,null,null),F=B.exports,P=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"tablecontaner"},[0!=e.tableColumn.length?a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],ref:"table",staticClass:"tablepad",attrs:{height:"calc(100vh - 235px)","row-class-name":e.tableRowClassName,"tooltip-effect":"dark",data:e.tableData,"element-loading-text":"拼命加载中","row-style":{height:"36px"},"cell-style":{padding:"0px"},"header-row-style":{height:"20px"}},on:{"selection-change":e.handleSelectionChange}},[a("el-table-column",{attrs:{type:"selection",width:"55"}}),e._l(e.tableColumn,(function(t){return a("el-table-column",{key:t.row_id,attrs:{align:"center",prop:t.prop,label:t.label,"min-width":"150","show-overflow-tooltip":"",fixed:t.fixed},scopedSlots:e._u([{key:"default",fn:function(n){return[t.index?a("span",[t.fristEnten?a("el-link",{on:{click:function(a){e.$emit(t.func,n.row,e.getEnterFiled())}}},[e._v(" "+e._s(n["$index"]+1))]):a("span",[e._v(" "+e._s(n["$index"]+1)+" ")])],1):t.isAction?a("span",[e._l(t.actionItem,(function(t){return a("el-button",{directives:[{name:"show",rawName:"v-show",value:e.istrue(t.condition,n.row),expression:"istrue(actionItem.condition, scope.row)"}],key:t.text,staticClass:"btn-icon",attrs:{type:"text",size:"small"},on:{click:function(a){e.$emit(t.func,n.row,e.getEnterFiled())}}},[a("el-tooltip",{attrs:{effect:"light",enterable:!1,content:t.text,placement:"top"}},[a("i",{class:t.icon})])],1)})),e._l(t.popconfirmitem,(function(t){return a("el-popconfirm",{key:t.text,attrs:{title:t.title},on:{confirm:function(a){return e.$emit(t.func,n.row)}}},[a("el-button",{directives:[{name:"show",rawName:"v-show",value:e.istrue(t.condition,n.row),expression:"istrue(actionItem.condition, scope.row)"}],staticClass:"btn-icon",staticStyle:{"margin-left":"10px"},attrs:{slot:"reference",type:"text",size:"small"},slot:"reference"},[a("el-tooltip",{attrs:{effect:"light",enterable:!1,content:t.text,placement:"top"}},[a("i",{class:t.icon})])],1)],1)}))],2):t.level?a("span",[a("el-rate",{attrs:{value:n.row[t.prop],disabled:"","text-color":"#ff9900","score-template":"{value}"}})],1):a("span",{style:t.condition?e.istrue(t.condition,n.row)?t.style:"":t.style},[t.fristEnten?a("el-link",{on:{click:function(a){e.$emit(t.func,n.row,e.getEnterFiled())}}},[e._v(" "+e._s(n.row[t.prop]))]):t.map?a("span",[e._v(e._s(e._f("filterData")(n.row[t.prop],t.map)))]):a("span",[e._v(" "+e._s(n.row[t.prop])+" ")])],1)]}}],null,!0)})}))],2):e._e(),0!=e.tableColumn.length?a("div",{staticClass:"footer"},[a("div",[e.showBatchDel?a("el-button",{attrs:{disabled:!e.selectRows.length,type:"primary",size:"mini"},on:{click:function(t){return e.$emit("batchDel",e.selectRows)}}},[e._v("批量删除")]):e._e()],1),a("div",[a("el-pagination",{attrs:{background:"","page-size":e.pageNum,layout:"prev, pager, next, total",total:e.pagetotal,"current-page":e.pageNo},on:{"update:currentPage":function(t){e.pageNo=t},"update:current-page":function(t){e.pageNo=t},"current-change":function(t){e.$emit("handlePageChange",t)}}})],1),a("div",[e.showExport?a("el-button",{attrs:{type:"primary",size:"mini"}},[e._v("导出")]):e._e()],1)]):e._e()],1)},I=[],U=a("469b"),V=U["a"],z=(a("8b48"),Object(E["a"])(V,P,I,!1,null,null,null)),q=z.exports,W=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"fromContainer"},[a("el-form",{ref:"form",attrs:{model:e.form,"status-icon":"",rules:e.rules,"label-width":"100px",size:"mini",labelWidth:"auto"}},[a("el-row",{attrs:{gutter:20}},[a("el-col",{attrs:{sm:24,md:18,lg:18,xl:12,offset:0}},e._l(e.showFiledData,(function(t){return a("el-form-item",{key:t.row_id,attrs:{label:t.name+"：",prop:t.en_name}},[1==t.show_type?a("el-input",{model:{value:e.form[t.en_name],callback:function(a){e.$set(e.form,t.en_name,a)},expression:"form[item.en_name]"}}):e._e(),2==t.show_type?a("fragment",e._l(e.selectdata[t.en_name],(function(n){return a("el-radio",{key:n.row_id,attrs:{label:n.row_id},model:{value:e.form[t.en_name],callback:function(a){e.$set(e.form,t.en_name,a)},expression:"form[item.en_name]"}},[e._v(e._s(n.name))])})),1):e._e(),3==t.show_type?a("el-checkbox-group",{on:{change:function(a){return e.handleChange(t.en_name)}},model:{value:e.checkList[t.en_name],callback:function(a){e.$set(e.checkList,t.en_name,a)},expression:"checkList[item.en_name]"}},e._l(e.selectdata[t.en_name],(function(t){return a("el-checkbox",{key:t.row_id,attrs:{label:t.row_id}},[e._v(e._s(t.name))])})),1):e._e(),4==t.show_type?a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"请选择",clearable:""},model:{value:e.form[t.en_name],callback:function(a){e.$set(e.form,t.en_name,a)},expression:"form[item.en_name]"}},e._l(e.selectdata[t.en_name],(function(e){return a("el-option",{key:e.row_id,attrs:{label:e.name?e.name:e.name_chn,value:e.row_id}})})),1):5==t.show_type?a("el-input",{staticClass:"textareaNOPut",attrs:{type:"textarea",size:"medium",rows:"4"},model:{value:e.form[t.en_name],callback:function(a){e.$set(e.form,t.en_name,a)},expression:"form[item.en_name]"}}):6==t.show_type?a("ImageUpload",{attrs:{imgsrc:e.form[t.en_name],filedname:t.en_name}}):7==t.show_type?a("el-date-picker",{attrs:{"value-format":"yyyy-MM-dd",format:"yyyy-MM-dd",type:"date"},model:{value:e.form[t.en_name],callback:function(a){e.$set(e.form,t.en_name,a)},expression:"form[item.en_name]"}}):10==t.show_type?a("FileUpload",{attrs:{filesrc:e.form[t.en_name],filedname:t.en_name}}):e._e()],1)})),1)],1),a("el-form-item",[a("el-button",{attrs:{type:"primary"},on:{click:e.clickSave}},[e._v("保存")]),a("el-button",{on:{click:function(t){return e.$emit("closetForm")}}},[e._v("关闭")])],1)],1)],1)},K=[],Y=a("b85c");a("a9e3"),a("5319"),a("4d90"),a("99af");function J(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"yyyy-MM-dd hh:mm:ss";if(e){var a=new Date(e),n={"M+":a.getMonth()+1,"d+":a.getDate(),"h+":a.getHours(),"m+":a.getMinutes(),"s+":a.getSeconds(),"q+":Math.floor((a.getMonth()+3)/3),S:a.getMilliseconds()};for(var i in/(y+)/.test(t)&&(t=t.replace(RegExp.$1,"".concat(a.getFullYear()).substr(4-RegExp.$1.length))),n)new RegExp("(".concat(i,")")).test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?n[i]:"00".concat(n[i]).substr("".concat(n[i]).length)));return t}}function Q(){return setTimeout((function(){var e=document.getElementsByClassName("is-error");e[0].querySelector("input").focus()}),100),!1}function Z(){var e=["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],t=(new Date).getDay();return e[t]}var H,X=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("fragment",[a("div",{directives:[{name:"show",rawName:"v-show",value:e.imgsrc,expression:"imgsrc"}],staticClass:"avatar-uploader el-upload imgLoadBox"},[a("img",{staticClass:"avatar",attrs:{src:(e.imgsrc?"/amobiletour_php/gthmmc":"")+e.imgsrc}}),a("div",{staticClass:"imgBoxmMask"}),a("i",{staticClass:"el-icon-delete",on:{click:function(t){return e.handleRemove(e.filedname)}}}),a("i",{staticClass:"el-icon-zoom-in",style:{"margin-left":"25%"},on:{click:function(t){return e.previewImg(e.filedname)}}})]),a("el-upload",{directives:[{name:"show",rawName:"v-show",value:!e.imgsrc,expression:"!imgsrc"}],staticClass:"avatar-uploader",attrs:{name:"Filedata",action:"/amobiletour_php/gthmmc/gthmmc/index.php?m=amobiletour&c=uploadWeb&a=imageUpload","on-success":function(t,a){return e.handleAvatarSuccess(t,e.filedname)},"list-type":"picture","show-file-list":!1}},[a("img",{directives:[{name:"show",rawName:"v-show",value:e.imgsrc,expression:"imgsrc"}],staticClass:"avatar el-icon-plus",attrs:{src:e.imgsrc}}),a("i",{staticClass:"el-icon-plus avatar-uploader-icon"})]),a("el-dialog",{attrs:{visible:e.dialogVisible[e.filedname]},on:{"update:visible":function(t){return e.$set(e.dialogVisible,e.filedname,t)}}},[a("img",{attrs:{width:"100%",src:(e.imgsrc?"/amobiletour_php/gthmmc":"")+e.imgsrc,alt:""}})])],1)},G=[],ee={props:["imgsrc","filedname"],data:function(){return{loadprogress:[],dialogVisible:{},form:{}}},methods:{handleAvatarSuccess:function(e,t){this.$bus.$emit("imgUploaded",e,t)},handleRemove:function(e){this.$bus.$emit("imgRemoved",e)},previewImg:function(e){this.$set(this.dialogVisible,e,!0)}}},te=ee,ae=(a("d091"),Object(E["a"])(te,X,G,!1,null,"2a16d4b6",null)),ne=ae.exports,ie=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("fragment",[a("el-upload",{ref:"upload",staticClass:"upload-demo",attrs:{limit:1,action:"/amobiletour_php/gthmmc/gthmmc/index.php?m=amobiletour&c=uploadWeb&a=fileUpload","on-success":function(t,a){return e.handleAvatarSuccess(t,e.filedname)},name:"Filedata","file-list":e.fileList,"list-type":"text","show-file-list":!1}},[a("el-button",{attrs:{size:"medium",type:"primary"}},[e._v("点击上传")]),a("div",{directives:[{name:"show",rawName:"v-show",value:!e.filesrc,expression:"!filesrc"}],staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"},[e._v(" 暂无文档 仅允许上传文档类型 ")])],1),a("a",{directives:[{name:"show",rawName:"v-show",value:""!==e.filesrc,expression:"filesrc !== ''"}],attrs:{download:(e.filesrc?"/amobiletour_php/gthmmc":"")+e.filesrc,href:(e.filesrc?"/amobiletour_php/gthmmc":"")+e.filesrc}},[e._v(e._s(e._f("filepathfilter")(e.filesrc)))]),a("el-tooltip",{directives:[{name:"show",rawName:"v-show",value:e.filesrc,expression:"filesrc"}],staticStyle:{"margin-left":"20px"},attrs:{content:"删除",enterable:!1,effect:"light",placement:"top"}},[a("el-link",{attrs:{icon:"el-icon-delete",underline:!1,type:"primary"},on:{click:function(t){return e.handleRemove(e.filedname)}}})],1)],1)},oe=[],se={props:["filesrc","filedname"],data:function(){return{loadprogress:[],dialogVisible:{},form:{},fileList:[]}},methods:{handleAvatarSuccess:function(e,t){this.$bus.$emit("imgUploaded",e,t)},handleRemove:function(e){this.fileList=[],this.$bus.$emit("imgRemoved",e)},previewImg:function(e){this.$set(this.dialogVisible,e,!0)}},filters:{filepathfilter:function(e){if(e){var t=e.lastIndexOf("/");return e=e.substring(t+1,e.length),e}}}},re=se,le=Object(E["a"])(re,ie,oe,!1,null,"1ac57bc2",null),ce=le.exports,ue={components:{ImageUpload:ne,FileUpload:ce},props:{showFiledData:{type:Array},form:{type:Object,default:{}},selectdata:{type:Object,default:function(){return{}}},isEdit:{type:Boolean,default:!1},rules:{type:Object,default:function(){return{}}}},data:function(){return{}},mounted:function(){this.handleBackView()},methods:(H={handleBackView:function(){var e,t=Object(Y["a"])(this.showFiledData);try{for(t.s();!(e=t.n()).done;){var a=e.value;this.isEdit?!this.form[a.en_name]||"2"!=a.show_type&&"4"!=a.show_type||Number(this.form[a.en_name])&&(this.form[a.en_name]=Number(this.form[a.en_name])):"2"!=a.show_type||a.associate?"4"!=a.show_type||a.associate||(this.form[a.en_name]="1"):this.$set(this.form,a.en_name,1)}}catch(n){t.e(n)}finally{t.f()}},closetForm:function(){this.$refs["tabbar"].removeTab("editpage")}},Object(L["a"])(H,"closetForm",(function(){})),Object(L["a"])(H,"uploadAvatarProcess",(function(e,t,a){})),Object(L["a"])(H,"clickSave",(function(){var e=this;this.$refs["form"].validate((function(t){t?e.$emit("submitForm",e.form):Q()}))})),H)},de=ue,me=(a("3852"),Object(E["a"])(de,W,K,!1,null,"238e49bf",null)),fe=me.exports;function pe(e,t,a){var n=/^[0-9]*$/;t?n.test(t)?a():a(new Error("只能输入数字")):a()}var he={components:{MainTabBar:F,TableComp:q,FromData:fe},data:function(){return{tabitem:[{name:"sjy",label:""}],tableData:[],tableColumn:[],pageNum:10,pagetotal:0,pageNo:1,tabEditLabel:"",activename:"",typeList:[],showTableLoading:!1,showTabLoading:!1,isEdit:!1,currentNav:{},fieldData:[],form:{},selectData:{},fieldMap:{},rules:{},searchKey:"",idToName:["play_id","payment","parent_id","modul_id"]}},created:function(){this.$bus.$off("imgUploaded",this.imgUploaded),this.$bus.$off("imgRemoved",this.imgRemoved)},mounted:function(){this.activename="sjy",this.currentNav=this.$store.state.currentNav,this.$set(this.tabitem[0],"label",this.currentNav.name),this.getResourcefield(),this.$bus.$on("imgUploaded",this.imgUploaded),this.$bus.$on("imgRemoved",this.imgRemoved)},destroyed:function(){},computed:{listenCurrentNav:function(){return this.searchKey="",this.$store.state.currentNav},showFieldData:function(){return this.fieldData.filter((function(e){return"0"!=e.show_type}))}},watch:{listenCurrentNav:function(e){var t=this;this.$nextTick((function(){t.$set(t.tabitem[0],"label",e.name)})),this.currentNav=e,this.getResourcefield(),this.closetForm()}},methods:{getResourcefield:function(){var e=this;this.showTabLoading=!0,this.pageNo=1;var t={directory_code:this.currentNav.index};g(t).then((function(t){e.fieldData=t.data.list,0==e.fieldData||e.fieldData[0].code!=e.currentNav.index?(e.tableData=[],e.tableColumn=[],e.showTabLoading=!1):(e.handleSelectData(),e.pagetotal=t.total)})).catch((function(e){}))},onQuery:function(){this.pagetotal=0,this.queryDataOfResource()},queryDataOfResource:function(){var e,t=this;this.showTabLoading||(this.showTabLoading=!0);var a={data:(e={},Object(L["a"])(e,this.tableColumn[0].prop,this.searchKey),Object(L["a"])(e,"is_check",1),e),pageNo:this.pageNo,pageNum:this.pageNum,directory_code:this.currentNav.index};_(a).then((function(e){e.directory_code==t.currentNav.index?(t.tableData=e.data,t.pagetotal=e.total,t.showTabLoading=!1):t.showTabLoading=!1})).catch((function(e){t.showTabLoading=!1}))},handleColumn:function(e){var t=this;this.tableColumn=[];var a=e.filter((function(e){return"1"==e.is_intable}));a.forEach((function(e,a){var n={label:"",prop:""};if(n.label=e.name,n.prop=e.en_name,0==a&&(n.fristEnten=!0,n.func="editRow"),t.idToName.includes(e.en_name)&&("2"==e.show_type||"4"==e.show_type)){var i=[],o=t.selectData[e.en_name];o&&(o.forEach((function(e){i.push([e.row_id,e.name])})),n.map=new Map(i))}t.tableColumn.push(n)})),this.tableColumn.push({label:"操作",isAction:!0,fixed:"right",actionItem:[{text:"编辑",icon:"el-icon-edit",type:"primary",func:"editRow"}],popconfirmitem:[{text:"删除",icon:"el-icon-delete",func:"delRow",title:"确定删除这条数据吗？"}]})},handleSelectData:function(){var e=this;Object.keys(this.rules).forEach((function(t){e.rules[t]=""})),this.showFieldData.forEach((function(t,a){var n;e.fieldMap[t.en_name]=t.type,2!=t.show_type&&4!=t.show_type||t.associate?!t.associate||0==t.associate.length||2!=t.show_type&&3!=t.show_type&&4!=t.show_type&&9!=t.show_type||e.queryDataOfResourceForSelect(t.en_name,t.associate):e.selectData[t.en_name]=[{name:"是",row_id:1},{name:"否",row_id:0}],-1!=t.type.indexOf("int")&&(n={validator:pe,trigger:"blur"},e.rules[t.en_name]=[],e.rules[t.en_name].push(n)),1==t.restraint&&(n={required:!0,message:"请输入"+t.name,trigger:"blur"},4==t.show_type?n={required:!0,message:"请选择"+t.name,trigger:"blur"}:6==t.show_type&&(n={required:!0,message:"请上传图片",trigger:"blur"}),e.rules[t.en_name]=[],e.rules[t.en_name].push(n))})),this.handleColumn(this.fieldData),this.queryDataOfResource()},queryDataOfResourceForSelect:function(e,t){var a=this,n={data:{is_check:1},pageNo:this.pageNo,pageNum:this.pageNum,directory_code:t};_(n).then((function(t){0==t.errcode&&(a.selectData[e]=[],a.selectData[e]=t.data,a.handleColumn(a.fieldData))})).catch((function(e){a.showTabLoading=!1}))},handlePageChange:function(e){this.pageNo=e,this.queryDataOfResource()},editRow:function(e,t){this.form=JSON.parse(JSON.stringify(e)),this.tabEditLabel=e[t]+"-编辑",this.activename="editpage",this.$refs.tabbar.activeName="editpage",this.isEdit=!0,this.isIncludes(this.activename)?this.tabitem[1].label=this.tabEditLabel:this.tabitem.push({name:"editpage",label:this.tabEditLabel,closable:!0})},delRow:function(e){this.deleteData(e)},batchDel:function(e){var t=this;this.$confirm("此操作将永久删除该数据, 是否继续?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){var a={rows:e.map((function(e){return e.row_id})),directory_code:t.currentNav.index};C(a).then((function(e){0==e.errcode?(t.$message({showClose:!0,message:"数据删除成功",type:"success"}),t.queryDataOfResource()):t.$message.error(e.errMsg)}))})).catch((function(){}))},handleAdd:function(){this.tabEditLabel="新增",this.activename="editpage",this.$refs.tabbar.activeName="editpage",this.isEdit=!1,this.isIncludes(this.activename)?this.tabitem[1].label=this.tabEditLabel:this.tabitem.push({name:"editpage",label:this.tabEditLabel,closable:!0})},handleTabClick:function(e){this.activename=e.name},closeTab:function(){for(var e in this.form)this.form[e]=""},closetForm:function(){this.form={},this.$refs["tabbar"].removeTab("editpage")},submitForm:function(e){var t=this.clearSubmitData(e);console.log(t),this.isEdit?this.modifyData(t):this.addData(t)},clearSubmitData:function(e){var t=this;return delete e.create_time,Object.keys(e).map((function(a){var n=!1;return t.fieldMap.hasOwnProperty(a)&&(n=-1!=t.fieldMap[a].indexOf("int")),n&&""===e[a]&&(e[a]=0),!0})),e},modifyData:function(e){var t=this,a={data:e,directory_code:this.currentNav.index};y(a).then((function(e){0==e.errCode&&(t.$message({message:"修改成功",type:"success"}),t.queryDataOfResource(),t.closetForm())})).catch((function(e){}))},addData:function(e){var t=this,a={data:e,directory_code:this.currentNav.index};w(a).then((function(e){0==e.errCode&&(t.$message({message:"新增成功",type:"success"}),t.getResourcefield(),t.closetForm())})).catch((function(e){}))},deleteData:function(e){var t=this,a={data:{row_id:e.row_id},directory_code:this.currentNav.index};x(a).then((function(e){0==e.errCode&&(t.$message({message:"删除成功",type:"success"}),t.queryDataOfResource())})).catch((function(e){}))},isIncludes:function(e){return this.tabitem.filter((function(t){return[e].includes(t.name)})).length>0},imgUploaded:function(e,t){this.$set(this.form,t,e.path)},imgRemoved:function(e){this.form[e]=""}}},ve=he,be=Object(E["a"])(ve,R,$,!1,null,"3f747a96",null),ge=be.exports,_e=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div")},we=[],ye={data:function(){return{}},methods:{getLoginPage:function(){Se()}},created:function(){this.getLoginPage()}},xe=ye,Ce=Object(E["a"])(xe,_e,we,!1,null,null,null),ke=Ce.exports;n["default"].use(d["a"]);var De=[{path:"/",name:"Home",redirect:{name:"home"}},{path:"/home",name:"home",component:O},{path:"/modelmanage",name:"modelmanage",component:ge},{path:"/loginpage",name:"loginpage",component:ke}],Ne=d["a"].prototype.push;d["a"].prototype.push=function(e){return Ne.call(this,e).catch((function(e){return e}))};var Ee=new d["a"]({mode:"hash",base:"./",routes:De}),Ae=Ee,Oe=($e("code"),document.URL);function Re(e){for(var t=window.location.search.substring(1),a=t.split("&"),n=0;n<a.length;n++){var i=a[n].split("=");if(i[0]==e)return i[1]}return!1}function $e(e){var t=new RegExp("(^|&)"+e+"=([^&]*)(&|$)"),a=window.location.search.substr(1).match(t);return null!=a?unescape(a[2]):null}function Le(){var e=$e("login_page");e||(e="");var t=$e("u");t||(t="");var a=$e("p");a||(a="");var n=$e("l");n||(n="");var i=$e("t");i||(i=""),window.location=Object({NODE_ENV:"production",VUE_APP_BASE_URL:"http://db.likezou.com:8080/cgi-bin",BASE_URL:"./"}).VUE_APP_Log_out+Oe+"&login_page="+e+"&t="+i+"&l="+n}function Se(){var e=Re("code"),t=$e("login_page");t||(t="gc");var a=$e("u");a||(a="");var n=$e("p");n||(n="");var i=$e("l");i||(i="");var o=$e("t");o||(o="");var s=document.URL;e&&""!=e?(u.commit("setLoginStatus",!0),Ae.push({name:"Home"})):(Oe=encodeURIComponent(s),window.location=Object({NODE_ENV:"production",VUE_APP_BASE_URL:"http://db.likezou.com:8080/cgi-bin",BASE_URL:"./"}).VUE_APP_Log_in+"?client_id=appid&redirect_uri="+Oe+"&response_type=code&scope=read")}var je={data:function(){return{activeIndex:"1",activeIndex2:"1",time:J(new Date,"hh:mm:ss"),date:J(new Date,"yyyy-MM-dd"),week:Z(),isShowLogout:!1}},methods:{logout:function(){Le()},handleSelect:function(e,t){console.log(e,t)}},mounted:function(){var e=this;this.timer=setInterval((function(){e.time=J(new Date,"hh:mm:ss")}),1e3)},beforeDestroy:function(){this.timer&&clearInterval(this.timer)}},Te=je,Me=(a("61a0"),Object(E["a"])(Te,s,r,!1,null,"35f11e6e",null)),Be=Me.exports,Fe=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"leftnav"},[a("div",{staticClass:"colspan",on:{click:function(t){e.isCollapse=!e.isCollapse}}},[a("i",{directives:[{name:"show",rawName:"v-show",value:!e.isCollapse,expression:"!isCollapse"}],staticClass:"el-icon-caret-left iconcollapse"}),a("i",{directives:[{name:"show",rawName:"v-show",value:e.isCollapse,expression:"isCollapse"}],staticClass:"el-icon-caret-right iconcollapse"})]),a("div",{staticClass:"menu_box"},[a("el-menu",{staticClass:"el-menu-vertical-demo",attrs:{"default-active":"1",mode:"vertical","background-color":"#499afe","text-color":"#fff","active-text-color":"#fce169",collapse:e.isCollapse,"unique-opened":""},on:{open:e.handleOpen,close:e.handleClose}},e._l(e.leftNavData,(function(t){return a("fragment",{key:t.index},[t.childe?a("el-submenu",{key:t.index,attrs:{index:t.index}},[a("template",{slot:"title"},[a("i",{staticClass:"el-icon-document",staticStyle:{color:"#ffffff"}}),a("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(t.name))])]),e._l(t.childe,(function(t){return a("el-menu-item",{key:t.index,attrs:{index:t.index},on:{click:function(a){return e.menuClick(t)}}},[a("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(t.name))])])}))],2):a("el-menu-item",{attrs:{index:t.index},on:{click:function(a){return e.menuClick(t)}}},[a("i",{staticClass:"el-icon-c-scale-to-original"}),a("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(t.name))])])],1)})),1)],1)])},Pe=[],Ie=[{index:"home",name:"首页",icon:"",isRouter:!0},{index:"basicdata",name:"基础数据",childe:[{index:"play",name:"景点管理"},{index:"stay",name:"住宿管理"},{index:"food",name:"美食管理"},{index:"amuse",name:"娱乐管理"},{index:"pro_owner",name:"商店管理"},{index:"traffic",name:"出行管理"}]},{index:"travelCommunalFacilities",name:"景区设施",childe:[{index:"toilet",name:"公共厕所"}]},{index:"travelProduct",name:"旅游产品",childe:[{index:"commodity",name:"特色商品"},{index:"travel_line",name:"旅游路线"},{index:"ticket",name:"景区门票"}]},{index:"tourismInfo",name:"资讯信息",childe:[{index:"amt_informationpush",name:"信息推送"},{index:"amt_active",name:"优惠活动"},{index:"newsinformatio",name:"新闻资讯"}]},{index:"travelagent",name:"游客互动",childe:[{index:"sosinfo",name:"旅游求助"},{index:"comment",name:"游客评论"},{index:"qainfo",name:"游客问答"},{index:"consultation",name:"游客咨询"},{index:"complaint_case",name:"游客投诉"},{index:"amt_telephone",name:"常用电话"},{index:"member",name:"会员列表"}]},{index:"foo",name:"统计分析"},{index:"systemcConfig",name:"系统配置",childe:[{index:"system_config",name:"基础配置"},{index:"amt_imageconf",name:"图片配置"},{index:"amt_modular",name:"模块配置"}]}],Ue={data:function(){return{isCollapse:!1,openeds:[1],leftNavData:Ie}},methods:{handleOpen:function(e,t){},handleClose:function(e,t){},menuClick:function(e){var t=e.index,a=e.name,n=e.isRouter;this.$store.commit("setcurrentNav",{index:t,name:a}),n?this.$router.push({name:t}):"modelmanage"!=this.$route&&this.$router.push({name:"modelmanage"})}}},Ve=Ue,ze=(a("c54e"),Object(E["a"])(Ve,Fe,Pe,!1,null,"5ceb5455",null)),qe=ze.exports,We={name:"App",components:{MainTabNav:Be,LeftNavBar:qe},created:function(){this.$router.push("/")}},Ke=We,Ye=(a("034f"),Object(E["a"])(Ke,i,o,!1,null,null,null)),Je=Ye.exports,Qe=a("5c96"),Ze=a.n(Qe),He=(a("0fae"),a("9c83"),a("34c4"),a("313e")),Xe=a("3f08");n["default"].prototype.$echarts=He,n["default"].config.productionTip=!1,n["default"].prototype.$bus=new n["default"],n["default"].use(Ze.a),n["default"].use(Xe["a"].Plugin),new n["default"]({router:Ae,store:u,render:function(e){return e(Je)}}).$mount("#app")},"61a0":function(e,t,a){"use strict";a("4db8")},"7a10":function(e,t,a){"use strict";a("c11d")},"85ec":function(e,t,a){},"8b48":function(e,t,a){"use strict";a("b376")},"9c83":function(e,t,a){},b376:function(e,t,a){},bbc7:function(e,t,a){},c11d:function(e,t,a){},c54e:function(e,t,a){"use strict";a("bbc7")},cb72:function(e,t,a){},d091:function(e,t,a){"use strict";a("e9ec")},e9ec:function(e,t,a){}});
//# sourceMappingURL=app.c5a37a7b.js.map