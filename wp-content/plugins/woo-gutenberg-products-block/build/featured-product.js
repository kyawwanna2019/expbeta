this.wc=this.wc||{},this.wc.blocks=this.wc.blocks||{},this.wc.blocks["featured-product"]=function(e){function t(t){for(var n,i,a=t[0],u=t[1],l=t[2],d=0,p=[];d<a.length;d++)i=a[d],c[i]&&p.push(c[i][0]),c[i]=0;for(n in u)Object.prototype.hasOwnProperty.call(u,n)&&(e[n]=u[n]);for(s&&s(t);p.length;)p.shift()();return r.push.apply(r,l||[]),o()}function o(){for(var e,t=0;t<r.length;t++){for(var o=r[t],n=!0,a=1;a<o.length;a++){var u=o[a];0!==c[u]&&(n=!1)}n&&(r.splice(t--,1),e=i(i.s=o[0]))}return e}var n={},c={5:0},r=[];function i(t){if(n[t])return n[t].exports;var o=n[t]={i:t,l:!1,exports:{}};return e[t].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=e,i.c=n,i.d=function(e,t,o){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(i.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(o,n,function(t){return e[t]}.bind(null,n));return o},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var a=window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[],u=a.push.bind(a);a.push=t,a=a.slice();for(var l=0;l<a.length;l++)t(a[l]);var s=u;return r.push([541,1,3,2,0]),o()}({0:function(e,t){!function(){e.exports=this.wp.element}()},1:function(e,t){!function(){e.exports=this.wp.i18n}()},17:function(e,t){!function(){e.exports=this.wp.apiFetch}()},18:function(e,t){!function(){e.exports=this.wp.editor}()},27:function(e,t){!function(){e.exports=this.wp.blocks}()},3:function(e,t){!function(){e.exports=this.wp.components}()},30:function(e,t){!function(){e.exports=this.wp.compose}()},35:function(e,t){!function(){e.exports=this.wp.url}()},38:function(e,t){!function(){e.exports=this.wp.keycodes}()},4:function(e,t){!function(){e.exports=this.lodash}()},50:function(e,t){!function(){e.exports=this.ReactDOM}()},51:function(e,t){!function(){e.exports=this.wp.viewport}()},539:function(e,t,o){var n=o(540);"string"==typeof n&&(n=[[e.i,n,""]]);var c={hmr:!0,transform:void 0,insertInto:void 0};o(66)(n,c);n.locals&&(e.exports=n.locals)},540:function(e,t,o){},541:function(e,t,o){"use strict";o.r(t);var n=o(0),c=o(1),r=o(18),i=o(27),a=(o(537),o(539),o(22)),u=o.n(a),l=o(23),s=o.n(l),d=o(24),p=o.n(d),b=o(25),h=o.n(b),f=o(33),g=o.n(f),m=o(26),w=o.n(m),_=o(17),O=o.n(_),k=o(3),v=o(6),j=o.n(v),y=o(30),S=o(4),C=o(5),P=o.n(C),E=o(37),x=o(78),I=function(e){function t(){var e;return u()(this,t),(e=p()(this,h()(t).apply(this,arguments))).state={list:[],loading:!0},e.debouncedOnSearch=Object(S.debounce)(e.onSearch.bind(g()(e)),400),e}return w()(t,e),s()(t,[{key:"componentDidMount",value:function(){var e=this,t=this.props.selected;Object(x.a)({selected:t}).then(function(t){e.setState({list:t,loading:!1})}).catch(function(){e.setState({list:[],loading:!1})})}},{key:"onSearch",value:function(e){var t=this,o=this.props.selected;Object(x.a)({selected:o,search:e}).then(function(e){t.setState({list:e,loading:!1})}).catch(function(){t.setState({list:[],loading:!1})})}},{key:"render",value:function(){var e=this.state,t=e.list,o=e.loading,r=this.props,i=r.onChange,a=r.selected,u={list:Object(c.__)("Products","woo-gutenberg-products-block"),noItems:Object(c.__)("Your store doesn't have any products.","woo-gutenberg-products-block"),search:Object(c.__)("Search for a product to display","woo-gutenberg-products-block"),updated:Object(c.__)("Product search results updated.","woo-gutenberg-products-block")};return Object(n.createElement)(n.Fragment,null,Object(n.createElement)(E.a,{className:"woocommerce-products",list:t,isLoading:o,isSingle:!0,selected:[Object(S.find)(t,{id:a})],onChange:i,onSearch:x.b?this.debouncedOnSearch:null,messages:u}))}}]),t}(n.Component);I.propTypes={onChange:P.a.func.isRequired,selected:P.a.number.isRequired};var M=I;function R(e){var t=e.images,o=void 0===t?[]:t;return o.length&&o[0].src||""}var T=wc_product_block_data.min_height;var N=function(e){function t(){var e;return u()(this,t),(e=p()(this,h()(t).apply(this,arguments))).state={product:!1,loaded:!1},e.debouncedGetProduct=Object(S.debounce)(e.getProduct.bind(g()(e)),200),e}return w()(t,e),s()(t,[{key:"componentDidMount",value:function(){this.getProduct()}},{key:"componentDidUpdate",value:function(e){e.attributes.productId!==this.props.attributes.productId&&this.debouncedGetProduct()}},{key:"getProduct",value:function(){var e=this,t=this.props.attributes.productId;t?O()({path:"/wc-blocks/v1/products/".concat(t)}).then(function(t){e.setState({product:t,loaded:!0})}).catch(function(){e.setState({product:!1,loaded:!0})}):this.setState({product:!1,loaded:!0})}},{key:"getInspectorControls",value:function(){var e=this.props,t=e.attributes,o=e.setAttributes,i=e.overlayColor,a=e.setOverlayColor,u=t.mediaSrc||R(this.state.product),l=t.focalPoint,s=void 0===l?{x:.5,y:.5}:l;return Object(n.createElement)(r.InspectorControls,{key:"inspector"},Object(n.createElement)(k.PanelBody,{title:Object(c.__)("Content","woo-gutenberg-products-block")},Object(n.createElement)(k.ToggleControl,{label:Object(c.__)("Show description","woo-gutenberg-products-block"),checked:t.showDesc,onChange:function(){return o({showDesc:!t.showDesc})}}),Object(n.createElement)(k.ToggleControl,{label:Object(c.__)("Show price","woo-gutenberg-products-block"),checked:t.showPrice,onChange:function(){return o({showPrice:!t.showPrice})}})),Object(n.createElement)(r.PanelColorSettings,{title:Object(c.__)("Overlay","woo-gutenberg-products-block"),colorSettings:[{value:i.color,onChange:a,label:Object(c.__)("Overlay Color","woo-gutenberg-products-block")}]},Object(n.createElement)(k.RangeControl,{label:Object(c.__)("Background Opacity","woo-gutenberg-products-block"),value:t.dimRatio,onChange:function(e){return o({dimRatio:e})},min:0,max:100,step:10}),!!k.FocalPointPicker&&!!u&&Object(n.createElement)(k.FocalPointPicker,{label:Object(c.__)("Focal Point Picker"),url:u,value:s,onChange:function(e){return o({focalPoint:e})}})))}},{key:"renderEditMode",value:function(){var e=this.props,t=e.attributes,o=e.debouncedSpeak,r=e.setAttributes;return Object(n.createElement)(k.Placeholder,{icon:"star-filled",label:Object(c.__)("Featured Product","woo-gutenberg-products-block"),className:"wc-block-featured-product"},Object(c.__)("Visually highlight a product and encourage prompt action","woo-gutenberg-products-block"),Object(n.createElement)("div",{className:"wc-block-handpicked-products__selection"},Object(n.createElement)(M,{selected:t.productId||0,onChange:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=e[0]?e[0].id:0;r({productId:t,mediaId:0,mediaSrc:""})}}),Object(n.createElement)(k.Button,{isDefault:!0,onClick:function(){r({editMode:!1}),o(Object(c.__)("Showing Featured Product block preview.","woo-gutenberg-products-block"))}},Object(c.__)("Done","woo-gutenberg-products-block"))))}},{key:"render",value:function(){var e,t,o,i,a=this,u=this.props,l=u.attributes,s=u.isSelected,d=u.overlayColor,p=u.setAttributes,b=l.className,h=l.contentAlign,f=l.dimRatio,g=l.editMode,m=l.focalPoint,w=l.height,_=l.showDesc,O=l.showPrice,v=this.state,y=v.loaded,C=v.product,P=j()("wc-block-featured-product",{"is-selected":s,"is-loading":!C&&!y,"is-not-found":!C&&y,"has-background-dim":0!==f},0===(e=f)||50===e?null:"has-background-dim-".concat(10*Math.round(e/10)),"center"!==h&&"has-".concat(h,"-content"),b),E=l.mediaId||(t=C.images,(o=void 0===t?[]:t).length&&o[0].id||0),x=C?(i=l.mediaSrc||C,Object(S.isObject)(i)&&(i=R(i)),i?{backgroundImage:"url(".concat(i,")")}:{}):{};d.color&&(x.backgroundColor=d.color),m&&(x.backgroundPosition="".concat(100*m.x,"% ").concat(100*m.y,"%"));return Object(n.createElement)(n.Fragment,null,Object(n.createElement)(r.BlockControls,null,Object(n.createElement)(r.AlignmentToolbar,{value:h,onChange:function(e){p({contentAlign:e})}}),Object(n.createElement)(r.MediaUploadCheck,null,Object(n.createElement)(k.Toolbar,null,Object(n.createElement)(r.MediaUpload,{onSelect:function(e){p({mediaId:e.id,mediaSrc:e.url})},allowedTypes:["image"],value:E,render:function(e){var t=e.open;return Object(n.createElement)(k.IconButton,{className:"components-toolbar__control",label:Object(c.__)("Edit media"),icon:"format-image",onClick:t,disabled:!a.state.product})}})))),!l.editMode&&this.getInspectorControls(),g?this.renderEditMode():Object(n.createElement)(n.Fragment,null,C?Object(n.createElement)(k.ResizableBox,{className:P,size:{height:w},minHeight:T,enable:{bottom:!0},onResizeStop:function(e,t,o){p({height:parseInt(o.style.height)})},style:x},Object(n.createElement)("div",{className:"wc-block-featured-product__wrapper"},Object(n.createElement)("h2",{className:"wc-block-featured-product__title",dangerouslySetInnerHTML:{__html:C.name}}),_&&Object(n.createElement)("div",{className:"wc-block-featured-product__description",dangerouslySetInnerHTML:{__html:C.short_description}}),O&&Object(n.createElement)("div",{className:"wc-block-featured-product__price",dangerouslySetInnerHTML:{__html:C.price_html}}),Object(n.createElement)("div",{className:"wc-block-featured-product__link"},Object(n.createElement)(r.InnerBlocks,{template:[["core/button",{text:Object(c.__)("Shop now","woo-gutenberg-products-block"),url:C.permalink,align:"center"}]],templateLock:"all"})))):Object(n.createElement)(k.Placeholder,{className:"wc-block-featured-product",icon:"star-filled",label:Object(c.__)("Featured Product","woo-gutenberg-products-block")},y?Object(c.__)("No product is selected.","woo-gutenberg-products-block"):Object(n.createElement)(k.Spinner,null))))}}]),t}(n.Component);N.propTypes={attributes:P.a.object.isRequired,isSelected:P.a.bool.isRequired,name:P.a.string.isRequired,setAttributes:P.a.func.isRequired,overlayColor:P.a.object,setOverlayColor:P.a.func.isRequired,debouncedSpeak:P.a.func.isRequired};var B=Object(y.compose)([Object(r.withColors)({overlayColor:"background-color"}),k.withSpokenMessages])(N);Object(i.registerBlockType)("woocommerce/featured-product",{title:Object(c.__)("Featured Product","woo-gutenberg-products-block"),icon:{src:"star-filled",foreground:"#96588a"},category:"woocommerce",keywords:[Object(c.__)("WooCommerce","woo-gutenberg-products-block")],description:Object(c.__)("Visually highlight a product and encourage prompt action.","woo-gutenberg-products-block"),supports:{align:["wide","full"]},attributes:{contentAlign:{type:"string",default:"center"},dimRatio:{type:"number",default:50},editMode:{type:"boolean",default:!0},focalPoint:{type:"object"},height:{type:"number",default:wc_product_block_data.default_height},mediaId:{type:"number",default:0},mediaSrc:{type:"string",default:""},overlayColor:{type:"string"},customOverlayColor:{type:"string"},linkText:{type:"string",default:Object(c.__)("Shop now","woo-gutenberg-products-block")},productId:{type:"number"},showDesc:{type:"boolean",default:!0},showPrice:{type:"boolean",default:!0}},edit:function(e){return Object(n.createElement)(B,e)},save:function(){return Object(n.createElement)(r.InnerBlocks.Content,null)}})},65:function(e,t){!function(){e.exports=this.wp.hooks}()},67:function(e,t){!function(){e.exports=this.wp.htmlEntities}()},68:function(e,t){!function(){e.exports=this.wp.date}()},76:function(e,t){!function(){e.exports=this.wp.dom}()},78:function(e,t,o){"use strict";o.d(t,"b",function(){return a}),o.d(t,"a",function(){return u});var n=o(35),c=o(17),r=o.n(c),i=o(4),a=wc_product_block_data.isLargeCatalog||!1,u=function(e){var t=e.selected,o=function(e){var t=e.selected,o=void 0===t?[]:t,c=e.search,r=[Object(n.addQueryArgs)("/wc-blocks/v1/products",{per_page:a?100:-1,catalog_visibility:"visible",status:"publish",search:c})];return a&&o.length&&r.push(Object(n.addQueryArgs)("/wc-blocks/v1/products",{catalog_visibility:"visible",status:"publish",include:o})),r}({selected:void 0===t?[]:t,search:e.search});return Promise.all(o.map(function(e){return r()({path:e})})).then(function(e){return Object(i.uniqBy)(Object(i.flatten)(e),"id")})}},8:function(e,t){!function(){e.exports=this.moment}()},80:function(e,t){},81:function(e,t){},83:function(e,t){},84:function(e,t){},9:function(e,t){!function(){e.exports=this.React}()}});