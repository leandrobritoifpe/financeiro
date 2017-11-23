/*! jQuery UI - v1.9.2 - 2016-06-01
* http://jqueryui.com
* Copyright jQuery Foundation and other contributors; Licensed MIT */

(function(e,t){var i="ui-dialog ui-widget ui-widget-content ui-corner-all ",s={buttons:!0,height:!0,maxHeight:!0,maxWidth:!0,minHeight:!0,minWidth:!0,width:!0},n={maxHeight:!0,maxWidth:!0,minHeight:!0,minWidth:!0};e.widget("ui.dialog",{version:"1.9.2",options:{autoOpen:!0,buttons:{},closeOnEscape:!0,closeText:"close",dialogClass:"",draggable:!0,hide:null,height:"auto",maxHeight:!1,maxWidth:!1,minHeight:150,minWidth:150,modal:!1,position:{my:"center",at:"center",of:window,collision:"fit",using:function(t){var i=e(this).css(t).offset().top;0>i&&e(this).css("top",t.top-i)}},resizable:!0,show:null,stack:!0,title:"",width:300,zIndex:1e3},_create:function(){this.originalTitle=this.element.attr("title"),"string"!=typeof this.originalTitle&&(this.originalTitle=""),this.oldPosition={parent:this.element.parent(),index:this.element.parent().children().index(this.element)},this.options.title=this.options.title||this.originalTitle;var s,n,a,o,r,h=this,l=this.options,u=l.title||"&#160;";s=(this.uiDialog=e("<div>")).addClass(i+l.dialogClass).css({display:"none",outline:0,zIndex:l.zIndex}).attr("tabIndex",-1).keydown(function(t){l.closeOnEscape&&!t.isDefaultPrevented()&&t.keyCode&&t.keyCode===e.ui.keyCode.ESCAPE&&(h.close(t),t.preventDefault())}).mousedown(function(e){h.moveToTop(!1,e)}).appendTo("body"),this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(s),n=(this.uiDialogTitlebar=e("<div>")).addClass("ui-dialog-titlebar  ui-widget-header  ui-corner-all  ui-helper-clearfix").bind("mousedown",function(){s.focus()}).prependTo(s),a=e("<a href='#'></a>").addClass("ui-dialog-titlebar-close  ui-corner-all").attr("role","button").click(function(e){e.preventDefault(),h.close(e)}).appendTo(n),(this.uiDialogTitlebarCloseText=e("<span>")).addClass("ui-icon ui-icon-closethick").text(l.closeText).appendTo(a),o=e("<span>").uniqueId().addClass("ui-dialog-title").html(u).prependTo(n),r=(this.uiDialogButtonPane=e("<div>")).addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"),(this.uiButtonSet=e("<div>")).addClass("ui-dialog-buttonset").appendTo(r),s.attr({role:"dialog","aria-labelledby":o.attr("id")}),n.find("*").add(n).disableSelection(),this._hoverable(a),this._focusable(a),l.draggable&&e.fn.draggable&&this._makeDraggable(),l.resizable&&e.fn.resizable&&this._makeResizable(),this._createButtons(l.buttons),this._isOpen=!1,e.fn.bgiframe&&s.bgiframe(),this._on(s,{keydown:function(i){if(l.modal&&i.keyCode===e.ui.keyCode.TAB){var n=e(":tabbable",s),a=n.filter(":first"),o=n.filter(":last");return i.target!==o[0]||i.shiftKey?i.target===a[0]&&i.shiftKey?(o.focus(1),!1):t:(a.focus(1),!1)}}})},_init:function(){this.options.autoOpen&&this.open()},_destroy:function(){var e,t=this.oldPosition;this.overlay&&this.overlay.destroy(),this.uiDialog.hide(),this.element.removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body"),this.uiDialog.remove(),this.originalTitle&&this.element.attr("title",this.originalTitle),e=t.parent.children().eq(t.index),e.length&&e[0]!==this.element[0]?e.before(this.element):t.parent.append(this.element)},widget:function(){return this.uiDialog},close:function(t){var i,s,n=this;if(this._isOpen&&!1!==this._trigger("beforeClose",t))return this._isOpen=!1,this.overlay&&this.overlay.destroy(),this.options.hide?this._hide(this.uiDialog,this.options.hide,function(){n._trigger("close",t)}):(this.uiDialog.hide(),this._trigger("close",t)),e.ui.dialog.overlay.resize(),this.options.modal&&(i=0,e(".ui-dialog").each(function(){this!==n.uiDialog[0]&&(s=e(this).css("z-index"),isNaN(s)||(i=Math.max(i,s)))}),e.ui.dialog.maxZ=i),this},isOpen:function(){return this._isOpen},moveToTop:function(t,i){var s,n=this.options;return n.modal&&!t||!n.stack&&!n.modal?this._trigger("focus",i):(n.zIndex>e.ui.dialog.maxZ&&(e.ui.dialog.maxZ=n.zIndex),this.overlay&&(e.ui.dialog.maxZ+=1,e.ui.dialog.overlay.maxZ=e.ui.dialog.maxZ,this.overlay.$el.css("z-index",e.ui.dialog.overlay.maxZ)),s={scrollTop:this.element.scrollTop(),scrollLeft:this.element.scrollLeft()},e.ui.dialog.maxZ+=1,this.uiDialog.css("z-index",e.ui.dialog.maxZ),this.element.attr(s),this._trigger("focus",i),this)},open:function(){if(!this._isOpen){var t,i=this.options,s=this.uiDialog;return this._size(),this._position(i.position),s.show(i.show),this.overlay=i.modal?new e.ui.dialog.overlay(this):null,this.moveToTop(!0),t=this.element.find(":tabbable"),t.length||(t=this.uiDialogButtonPane.find(":tabbable"),t.length||(t=s)),t.eq(0).focus(),this._isOpen=!0,this._trigger("open"),this}},_createButtons:function(t){var i=this,s=!1;this.uiDialogButtonPane.remove(),this.uiButtonSet.empty(),"object"==typeof t&&null!==t&&e.each(t,function(){return!(s=!0)}),s?(e.each(t,function(t,s){var n,a;s=e.isFunction(s)?{click:s,text:t}:s,s=e.extend({type:"button"},s),a=s.click,s.click=function(){a.apply(i.element[0],arguments)},n=e("<button></button>",s).appendTo(i.uiButtonSet),e.fn.button&&n.button()}),this.uiDialog.addClass("ui-dialog-buttons"),this.uiDialogButtonPane.appendTo(this.uiDialog)):this.uiDialog.removeClass("ui-dialog-buttons")},_makeDraggable:function(){function t(e){return{position:e.position,offset:e.offset}}var i=this,s=this.options;this.uiDialog.draggable({cancel:".ui-dialog-content, .ui-dialog-titlebar-close",handle:".ui-dialog-titlebar",containment:"document",start:function(s,n){e(this).addClass("ui-dialog-dragging"),i._trigger("dragStart",s,t(n))},drag:function(e,s){i._trigger("drag",e,t(s))},stop:function(n,a){s.position=[a.position.left-i.document.scrollLeft(),a.position.top-i.document.scrollTop()],e(this).removeClass("ui-dialog-dragging"),i._trigger("dragStop",n,t(a)),e.ui.dialog.overlay.resize()}})},_makeResizable:function(i){function s(e){return{originalPosition:e.originalPosition,originalSize:e.originalSize,position:e.position,size:e.size}}i=i===t?this.options.resizable:i;var n=this,a=this.options,o=this.uiDialog.css("position"),r="string"==typeof i?i:"n,e,s,w,se,sw,ne,nw";this.uiDialog.resizable({cancel:".ui-dialog-content",containment:"document",alsoResize:this.element,maxWidth:a.maxWidth,maxHeight:a.maxHeight,minWidth:a.minWidth,minHeight:this._minHeight(),handles:r,start:function(t,i){e(this).addClass("ui-dialog-resizing"),n._trigger("resizeStart",t,s(i))},resize:function(e,t){n._trigger("resize",e,s(t))},stop:function(t,i){e(this).removeClass("ui-dialog-resizing"),a.height=e(this).height(),a.width=e(this).width(),n._trigger("resizeStop",t,s(i)),e.ui.dialog.overlay.resize()}}).css("position",o).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")},_minHeight:function(){var e=this.options;return"auto"===e.height?e.minHeight:Math.min(e.minHeight,e.height)},_position:function(t){var i,s=[],n=[0,0];t?(("string"==typeof t||"object"==typeof t&&"0"in t)&&(s=t.split?t.split(" "):[t[0],t[1]],1===s.length&&(s[1]=s[0]),e.each(["left","top"],function(e,t){+s[e]===s[e]&&(n[e]=s[e],s[e]=t)}),t={my:s[0]+(0>n[0]?n[0]:"+"+n[0])+" "+s[1]+(0>n[1]?n[1]:"+"+n[1]),at:s.join(" ")}),t=e.extend({},e.ui.dialog.prototype.options.position,t)):t=e.ui.dialog.prototype.options.position,i=this.uiDialog.is(":visible"),i||this.uiDialog.show(),this.uiDialog.position(t),i||this.uiDialog.hide()},_setOptions:function(t){var i=this,a={},o=!1;e.each(t,function(e,t){i._setOption(e,t),e in s&&(o=!0),e in n&&(a[e]=t)}),o&&this._size(),this.uiDialog.is(":data(resizable)")&&this.uiDialog.resizable("option",a)},_setOption:function(t,s){var n,a,o=this.uiDialog;switch(t){case"buttons":this._createButtons(s);break;case"closeText":this.uiDialogTitlebarCloseText.text(""+s);break;case"dialogClass":o.removeClass(this.options.dialogClass).addClass(i+s);break;case"disabled":s?o.addClass("ui-dialog-disabled"):o.removeClass("ui-dialog-disabled");break;case"draggable":n=o.is(":data(draggable)"),n&&!s&&o.draggable("destroy"),!n&&s&&this._makeDraggable();break;case"position":this._position(s);break;case"resizable":a=o.is(":data(resizable)"),a&&!s&&o.resizable("destroy"),a&&"string"==typeof s&&o.resizable("option","handles",s),a||s===!1||this._makeResizable(s);break;case"title":e(".ui-dialog-title",this.uiDialogTitlebar).html(""+(s||"&#160;"))}this._super(t,s)},_size:function(){var t,i,s,n=this.options,a=this.uiDialog.is(":visible");this.element.show().css({width:"auto",minHeight:0,height:0}),n.minWidth>n.width&&(n.width=n.minWidth),t=this.uiDialog.css({height:"auto",width:n.width}).outerHeight(),i=Math.max(0,n.minHeight-t),"auto"===n.height?e.support.minHeight?this.element.css({minHeight:i,height:"auto"}):(this.uiDialog.show(),s=this.element.css("height","auto").height(),a||this.uiDialog.hide(),this.element.height(Math.max(s,i))):this.element.height(Math.max(n.height-t,0)),this.uiDialog.is(":data(resizable)")&&this.uiDialog.resizable("option","minHeight",this._minHeight())}}),e.extend(e.ui.dialog,{uuid:0,maxZ:0,getTitleId:function(e){var t=e.attr("id");return t||(this.uuid+=1,t=this.uuid),"ui-dialog-title-"+t},overlay:function(t){this.$el=e.ui.dialog.overlay.create(t)}}),e.extend(e.ui.dialog.overlay,{instances:[],oldInstances:[],maxZ:0,events:e.map("focus,mousedown,mouseup,keydown,keypress,click".split(","),function(e){return e+".dialog-overlay"}).join(" "),create:function(i){0===this.instances.length&&(setTimeout(function(){e.ui.dialog.overlay.instances.length&&e(document).bind(e.ui.dialog.overlay.events,function(i){return e(i.target).zIndex()<e.ui.dialog.overlay.maxZ?!1:t})},1),e(window).bind("resize.dialog-overlay",e.ui.dialog.overlay.resize));var s=this.oldInstances.pop()||e("<div>").addClass("ui-widget-overlay");return e(document).bind("keydown.dialog-overlay",function(t){var n=e.ui.dialog.overlay.instances;0!==n.length&&n[n.length-1]===s&&i.options.closeOnEscape&&!t.isDefaultPrevented()&&t.keyCode&&t.keyCode===e.ui.keyCode.ESCAPE&&(i.close(t),t.preventDefault())}),s.appendTo(document.body).css({width:this.width(),height:this.height()}),e.fn.bgiframe&&s.bgiframe(),this.instances.push(s),s},destroy:function(t){var i=e.inArray(t,this.instances),s=0;-1!==i&&this.oldInstances.push(this.instances.splice(i,1)[0]),0===this.instances.length&&e([document,window]).unbind(".dialog-overlay"),t.height(0).width(0).remove(),e.each(this.instances,function(){s=Math.max(s,this.css("z-index"))}),this.maxZ=s},height:function(){var t,i;return e.ui.ie?(t=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight),i=Math.max(document.documentElement.offsetHeight,document.body.offsetHeight),i>t?e(window).height()+"px":t+"px"):e(document).height()+"px"},width:function(){var t,i;return e.ui.ie?(t=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth),i=Math.max(document.documentElement.offsetWidth,document.body.offsetWidth),i>t?e(window).width()+"px":t+"px"):e(document).width()+"px"},resize:function(){var t=e([]);e.each(e.ui.dialog.overlay.instances,function(){t=t.add(this)}),t.css({width:0,height:0}).css({width:e.ui.dialog.overlay.width(),height:e.ui.dialog.overlay.height()})}}),e.extend(e.ui.dialog.overlay.prototype,{destroy:function(){e.ui.dialog.overlay.destroy(this.$el)}})})(jQuery);