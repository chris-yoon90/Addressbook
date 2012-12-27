//>>built
define("dijit/_MenuBase",["dojo/_base/array","dojo/_base/declare","dojo/dom","dojo/dom-attr","dojo/dom-class","dojo/_base/lang","dojo/mouse","dojo/on","dojo/window","./a11yclick","./popup","./registry","./_Widget","./_KeyNavContainer","./_TemplatedMixin"],function(_1,_2,_3,_4,_5,_6,_7,on,_8,_9,pm,_a,_b,_c,_d){
return _2("dijit._MenuBase",[_b,_d,_c],{parentMenu:null,popupDelay:500,autoFocus:false,postCreate:function(){
var _e=this,_f=function(_10){
return _5.contains(_10,"dijitMenuItem");
};
this.own(on(this.containerNode,on.selector(_f,_7.enter),function(){
_e.onItemHover(_a.byNode(this));
}),on(this.containerNode,on.selector(_f,_7.leave),function(){
_e.onItemUnhover(_a.byNode(this));
}),on(this.containerNode,on.selector(_f,_9),function(evt){
_e.onItemClick(_a.byNode(this),evt);
evt.stopPropagation();
evt.preventDefault();
}));
this.inherited(arguments);
},onExecute:function(){
},onCancel:function(){
},_moveToPopup:function(evt){
if(this.focusedChild&&this.focusedChild.popup&&!this.focusedChild.disabled){
this.onItemClick(this.focusedChild,evt);
}else{
var _11=this._getTopMenu();
if(_11&&_11._isMenuBar){
_11.focusNext();
}
}
},_onPopupHover:function(){
if(this.currentPopup&&this.currentPopup._pendingClose_timer){
var _12=this.currentPopup.parentMenu;
if(_12.focusedChild){
_12.focusedChild._setSelected(false);
}
_12.focusedChild=this.currentPopup.from_item;
_12.focusedChild._setSelected(true);
this._stopPendingCloseTimer(this.currentPopup);
}
},onItemHover:function(_13){
if(this.isActive){
this.focusChild(_13);
if(this.focusedChild.popup&&!this.focusedChild.disabled&&!this.hover_timer){
this.hover_timer=this.defer("_openPopup",this.popupDelay);
}
}
if(this.focusedChild){
this.focusChild(_13);
}
this._hoveredChild=_13;
_13._set("hovering",true);
},_onChildBlur:function(_14){
this._stopPopupTimer();
_14._setSelected(false);
var _15=_14.popup;
if(_15){
this._stopPendingCloseTimer(_15);
_15._pendingClose_timer=this.defer(function(){
_15._pendingClose_timer=null;
if(_15.parentMenu){
_15.parentMenu.currentPopup=null;
}
pm.close(_15);
},this.popupDelay);
}
},onItemUnhover:function(_16){
if(this.isActive){
this._stopPopupTimer();
}
if(this._hoveredChild==_16){
this._hoveredChild=null;
}
_16._set("hovering",false);
},_stopPopupTimer:function(){
if(this.hover_timer){
this.hover_timer=this.hover_timer.remove();
}
},_stopPendingCloseTimer:function(_17){
if(_17._pendingClose_timer){
_17._pendingClose_timer=_17._pendingClose_timer.remove();
}
},_stopFocusTimer:function(){
if(this._focus_timer){
this._focus_timer=this._focus_timer.remove();
}
},_getTopMenu:function(){
for(var top=this;top.parentMenu;top=top.parentMenu){
}
return top;
},onItemClick:function(_18,evt){
if(typeof this.isShowingNow=="undefined"){
this._markActive();
}
this.focusChild(_18);
if(_18.disabled){
return false;
}
if(_18.popup){
this._openPopup(evt.type=="keypress");
}else{
this.onExecute();
_18._onClick?_18._onClick(evt):_18.onClick(evt);
}
},_openPopup:function(_19){
this._stopPopupTimer();
var _1a=this.focusedChild;
if(!_1a){
return;
}
var _1b=_1a.popup;
if(!_1b.isShowingNow){
if(this.currentPopup){
this._stopPendingCloseTimer(this.currentPopup);
pm.close(this.currentPopup);
}
_1b.parentMenu=this;
_1b.from_item=_1a;
var _1c=this;
pm.open({parent:this,popup:_1b,around:_1a.domNode,orient:this._orient||["after","before"],onCancel:function(){
_1c.focusChild(_1a);
_1c._cleanUp();
_1a._setSelected(true);
_1c.focusedChild=_1a;
},onExecute:_6.hitch(this,"_cleanUp")});
this.currentPopup=_1b;
_1b.connect(_1b.domNode,"onmouseenter",_6.hitch(_1c,"_onPopupHover"));
}
if(_19&&_1b.focus){
_1b._focus_timer=this.defer(_6.hitch(_1b,function(){
this._focus_timer=null;
this.focus();
}));
}
},_markActive:function(){
this.isActive=true;
_5.replace(this.domNode,"dijitMenuActive","dijitMenuPassive");
},onOpen:function(){
this.isShowingNow=true;
this._markActive();
},_markInactive:function(){
this.isActive=false;
_5.replace(this.domNode,"dijitMenuPassive","dijitMenuActive");
},onClose:function(){
this._stopFocusTimer();
this._markInactive();
this.isShowingNow=false;
this.parentMenu=null;
},_closeChild:function(){
this._stopPopupTimer();
if(this.currentPopup){
if(_1.indexOf(this._focusManager.activeStack,this.id)>=0){
_4.set(this.focusedChild.focusNode,"tabIndex",this.tabIndex);
this.focusedChild.focusNode.focus();
}
pm.close(this.currentPopup);
this.currentPopup=null;
}
if(this.focusedChild){
this.focusedChild._setSelected(false);
this.onItemUnhover(this.focusedChild);
this.focusedChild=null;
}
},_onItemFocus:function(_1d){
if(this._hoveredChild&&this._hoveredChild!=_1d){
this.onItemUnhover(this._hoveredChild);
}
},_onBlur:function(){
this._cleanUp();
this.inherited(arguments);
},_cleanUp:function(){
this._closeChild();
if(typeof this.isShowingNow=="undefined"){
this._markInactive();
}
}});
});
