(function(a,b){if(typeof exports==="object"){module.exports=b()}else{if(typeof define==="function"&&define.amd){define("GMaps",[],b)}}a.GMaps=b()}(this,function(){
/*!
 * GMaps.js v0.4.16
 * http://hpneo.github.com/gmaps/
 *
 * Copyright 2014, Gustavo Leon
 * Released under the MIT License.
 */
if(!(typeof window.google==="object"&&window.google.maps)){throw"Google Maps API is required. Please register the following JavaScript library http://maps.google.com/maps/api/js?sensor=true."}var h=function(n,o){var m;if(n===o){return n}for(m in o){n[m]=o[m]}return n};var d=function(o,n){var m;if(o===n){return o}for(m in n){if(o[m]!=undefined){o[m]=n[m]}}return o};var k=function(r,q){var n=Array.prototype.slice.call(arguments,2),p=[],m=r.length,o;if(Array.prototype.map&&r.map===Array.prototype.map){p=Array.prototype.map.call(r,function(s){callback_params=n;callback_params.splice(0,0,s);return q.apply(this,callback_params)})}else{for(o=0;o<m;o++){callback_params=n;callback_params.splice(0,0,r[o]);p.push(q.apply(this,callback_params))}}return p};var f=function(o){var n=[],m;for(m=0;m<o.length;m++){n=n.concat(o[m])}return n};var l=function(n,o){var p=n[0],m=n[1];if(o){p=n[1];m=n[0]}return new google.maps.LatLng(p,m)};var i=function(n,o){var m;for(m=0;m<n.length;m++){if(!(n[m] instanceof google.maps.LatLng)){if(n[m].length>0&&typeof(n[m][0])=="object"){n[m]=i(n[m],o)}else{n[m]=l(n[m],o)}}}return n};var a=function(o,n){var m,o=o.replace("#","");if("jQuery" in this&&n){m=$("#"+o,n)[0]}else{m=document.getElementById(o)}return m};var g=function(n){var o=0,m=0;if(n.offsetParent){do{o+=n.offsetLeft;m+=n.offsetTop}while(n=n.offsetParent)}return[o,m]};var j=(function(n){var o=document;var m=function(u){if(!this){return new m(u)}u.zoom=u.zoom||15;u.mapType=u.mapType||"roadmap";var J=this,L,w=["bounds_changed","center_changed","click","dblclick","drag","dragend","dragstart","idle","maptypeid_changed","projection_changed","resize","tilesloaded","zoom_changed"],A=["mousemove","mouseout","mouseover"],C=["el","lat","lng","mapType","width","height","markerClusterer","enableNewStyle"],M=u.el||u.div,y=u.markerClusterer,N=google.maps.MapTypeId[u.mapType.toUpperCase()],H=new google.maps.LatLng(u.lat,u.lng),Q=u.zoomControl||false,q=u.zoomControlOpt||{style:"DEFAULT",position:"TOP_LEFT"},K=q.style||"DEFAULT",r=q.position||"TOP_LEFT",D=u.panControl||false,x=u.mapTypeControl||false,B=u.scaleControl||true,z=u.streetViewControl||false,v=v||true,I={},F={zoom:this.zoom,center:H,mapTypeId:N},p={panControl:D,zoomControl:Q,zoomControlOptions:{style:google.maps.ZoomControlStyle[K],position:google.maps.ControlPosition[r]},mapTypeControl:x,scaleControl:B,streetViewControl:z,overviewMapControl:v};if(typeof(u.el)==="string"||typeof(u.div)==="string"){this.el=a(M,u.context)}else{this.el=M}if(typeof(this.el)==="undefined"||this.el===null){throw"No element defined."}window.context_menu=window.context_menu||{};window.context_menu[J.el.id]={};this.controls=[];this.overlays=[];this.layers=[];this.singleLayers={};this.markers=[];this.polylines=[];this.routes=[];this.polygons=[];this.infoWindow=null;this.overlay_el=null;this.zoom=u.zoom;this.registered_events={};this.el.style.width=u.width||this.el.scrollWidth||this.el.offsetWidth;this.el.style.height=u.height||this.el.scrollHeight||this.el.offsetHeight;google.maps.visualRefresh=u.enableNewStyle;for(L=0;L<C.length;L++){delete u[C[L]]}if(u.disableDefaultUI!=true){F=h(F,p)}I=h(F,u);for(L=0;L<w.length;L++){delete I[w[L]]}for(L=0;L<A.length;L++){delete I[A[L]]}this.map=new google.maps.Map(this.el,I);if(y){this.markerClusterer=y.apply(this,[this.map])}var E=function(V,aa){var Z="",ae=window.context_menu[J.el.id][V];for(var W in ae){if(ae.hasOwnProperty(W)){var Y=ae[W];Z+='<li><a id="'+V+"_"+W+'" href="#">'+Y.title+"</a></li>"}}if(!a("gmaps_context_menu")){return}var ab=a("gmaps_context_menu");ab.innerHTML=Z;var R=ab.getElementsByTagName("a"),ad=R.length,W;for(W=0;W<ad;W++){var T=R[W];var U=function(af){af.preventDefault();ae[this.id.replace(V+"_","")].action.apply(J,[aa]);J.hideContextMenu()};google.maps.event.clearListeners(T,"click");google.maps.event.addDomListenerOnce(T,"click",U,false)}var X=g.apply(this,[J.el]),S=X[0]+aa.pixel.x-15,ac=X[1]+aa.pixel.y-15;ab.style.left=S+"px";ab.style.top=ac+"px";ab.style.display="block"};this.buildContextMenu=function(T,S){if(T==="marker"){S.pixel={};var R=new google.maps.OverlayView();R.setMap(J.map);R.draw=function(){var V=R.getProjection(),U=S.marker.getPosition();S.pixel=V.fromLatLngToContainerPixel(U);E(T,S)}}else{E(T,S)}};this.setContextMenu=function(R){window.context_menu[J.el.id][R.control]={};var T,S=o.createElement("ul");for(T in R.options){if(R.options.hasOwnProperty(T)){var U=R.options[T];window.context_menu[J.el.id][R.control][U.name]={title:U.title,action:U.action}}}S.id="gmaps_context_menu";S.style.display="none";S.style.position="absolute";S.style.minWidth="100px";S.style.background="white";S.style.listStyle="none";S.style.padding="8px";S.style.boxShadow="2px 2px 6px #ccc";o.body.appendChild(S);var V=a("gmaps_context_menu");google.maps.event.addDomListener(V,"mouseout",function(W){if(!W.relatedTarget||!this.contains(W.relatedTarget)){window.setTimeout(function(){V.style.display="none"},400)}},false)};this.hideContextMenu=function(){var R=a("gmaps_context_menu");if(R){R.style.display="none"}};var G=function(S,R){google.maps.event.addListener(S,R,function(T){if(T==undefined){T=this}u[R].apply(this,[T]);J.hideContextMenu()})};google.maps.event.addListener(this.map,"zoom_changed",this.hideContextMenu);for(var O=0;O<w.length;O++){var P=w[O];if(P in u){G(this.map,P)}}for(var O=0;O<A.length;O++){var P=A[O];if(P in u){G(this.map,P)}}google.maps.event.addListener(this.map,"rightclick",function(R){if(u.rightclick){u.rightclick.apply(this,[R])}if(window.context_menu[J.el.id]["map"]!=undefined){J.buildContextMenu("map",R)}});this.refresh=function(){google.maps.event.trigger(this.map,"resize")};this.fitZoom=function(){var T=[],R=this.markers.length,S;for(S=0;S<R;S++){if(typeof(this.markers[S].visible)==="boolean"&&this.markers[S].visible){T.push(this.markers[S].getPosition())}}this.fitLatLngBounds(T)};this.fitLatLngBounds=function(U){var T=U.length;var S=new google.maps.LatLngBounds();for(var R=0;R<T;R++){S.extend(U[R])}this.map.fitBounds(S)};this.setCenter=function(S,R,T){this.map.panTo(new google.maps.LatLng(S,R));if(T){T()}};this.getElement=function(){return this.el};this.zoomIn=function(R){R=R||1;this.zoom=this.map.getZoom()+R;this.map.setZoom(this.zoom)};this.zoomOut=function(R){R=R||1;this.zoom=this.map.getZoom()-R;this.map.setZoom(this.zoom)};var t=[],s;for(s in this.map){if(typeof(this.map[s])=="function"&&!this[s]){t.push(s)}}for(L=0;L<t.length;L++){(function(R,T,S){R[S]=function(){return T[S].apply(T,arguments)}})(this,this.map,t[L])}};return m})(this);j.prototype.createControl=function(m){var p=document.createElement("div");p.style.cursor="pointer";if(m.disableDefaultStyles!==true){p.style.fontFamily="Roboto, Arial, sans-serif";p.style.fontSize="11px";p.style.boxShadow="rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px"}for(var n in m.style){p.style[n]=m.style[n]}if(m.id){p.id=m.id}if(m.classes){p.className=m.classes}if(m.content){if(typeof m.content==="string"){p.innerHTML=m.content}else{if(m.content instanceof HTMLElement){p.appendChild(m.content)}}}if(m.position){p.position=google.maps.ControlPosition[m.position.toUpperCase()]}for(var o in m.events){(function(r,q){google.maps.event.addDomListener(r,q,function(){m.events[q].apply(this,[this])})})(p,o)}p.index=1;return p};j.prototype.addControl=function(m){var n=this.createControl(m);this.controls.push(n);this.map.controls[n.position].push(n);return n};j.prototype.removeControl=function(p){var m=null;for(var o=0;o<this.controls.length;o++){if(this.controls[o]==p){m=this.controls[o].position;this.controls.splice(o,1)}}if(m){for(o=0;o<this.map.controls.length;o++){var n=this.map.controls[p.position];if(n.getAt(o)==p){n.removeAt(o);break}}}return p};j.prototype.createMarker=function(x){if(x.lat==undefined&&x.lng==undefined&&x.position==undefined){throw"No latitude or longitude defined."}var w=this,n=x.details,r=x.fences,t=x.outside,q={position:new google.maps.LatLng(x.lat,x.lng),map:null},o=h(q,x);delete o.lat;delete o.lng;delete o.fences;delete o.outside;var s=new google.maps.Marker(o);s.fences=r;if(x.infoWindow){s.infoWindow=new google.maps.InfoWindow(x.infoWindow);var m=["closeclick","content_changed","domready","position_changed","zindex_changed"];for(var u=0;u<m.length;u++){(function(z,y){if(x.infoWindow[y]){google.maps.event.addListener(z,y,function(A){x.infoWindow[y].apply(this,[A])})}})(s.infoWindow,m[u])}}var v=["animation_changed","clickable_changed","cursor_changed","draggable_changed","flat_changed","icon_changed","position_changed","shadow_changed","shape_changed","title_changed","visible_changed","zindex_changed"];var p=["dblclick","drag","dragend","dragstart","mousedown","mouseout","mouseover","mouseup"];for(var u=0;u<v.length;u++){(function(z,y){if(x[y]){google.maps.event.addListener(z,y,function(){x[y].apply(this,[this])})}})(s,v[u])}for(var u=0;u<p.length;u++){(function(A,z,y){if(x[y]){google.maps.event.addListener(z,y,function(B){if(!B.pixel){B.pixel=A.getProjection().fromLatLngToPoint(B.latLng)}x[y].apply(this,[B])})}})(this.map,s,p[u])}google.maps.event.addListener(s,"click",function(){this.details=n;if(x.click){x.click.apply(this,[this])}if(s.infoWindow){w.hideInfoWindows();s.infoWindow.open(w.map,s)}});google.maps.event.addListener(s,"rightclick",function(y){y.marker=this;if(x.rightclick){x.rightclick.apply(this,[y])}if(window.context_menu[w.el.id]["marker"]!=undefined){w.buildContextMenu("marker",y)}});if(s.fences){google.maps.event.addListener(s,"dragend",function(){w.checkMarkerGeofence(s,function(y,z){t(y,z)})})}return s};j.prototype.addMarker=function(n){var m;if(n.hasOwnProperty("gm_accessors_")){m=n}else{if((n.hasOwnProperty("lat")&&n.hasOwnProperty("lng"))||n.position){m=this.createMarker(n)}else{throw"No latitude or longitude defined."}}m.setMap(this.map);if(this.markerClusterer){this.markerClusterer.addMarker(m)}this.markers.push(m);j.fire("marker_added",m,this);return m};j.prototype.addMarkers=function(o){for(var n=0,m;m=o[n];n++){this.addMarker(m)}return this.markers};j.prototype.hideInfoWindows=function(){for(var n=0,m;m=this.markers[n];n++){if(m.infoWindow){m.infoWindow.close()}}};j.prototype.removeMarker=function(m){for(var n=0;n<this.markers.length;n++){if(this.markers[n]===m){this.markers[n].setMap(null);this.markers.splice(n,1);if(this.markerClusterer){this.markerClusterer.removeMarker(m)}j.fire("marker_removed",m,this);break}}return m};j.prototype.removeMarkers=function(q){var m=[];if(typeof q=="undefined"){for(var p=0;p<this.markers.length;p++){var n=this.markers[p];n.setMap(null);if(this.markerClusterer){this.markerClusterer.removeMarker(n)}j.fire("marker_removed",n,this)}this.markers=m}else{for(var p=0;p<q.length;p++){var o=this.markers.indexOf(q[p]);if(o>-1){var n=this.markers[o];n.setMap(null);if(this.markerClusterer){this.markerClusterer.removeMarker(n)}j.fire("marker_removed",n,this)}}for(var p=0;p<this.markers.length;p++){var n=this.markers[p];if(n.getMap()!=null){m.push(n)}}this.markers=m}};j.prototype.drawOverlay=function(n){var m=new google.maps.OverlayView(),o=true;m.setMap(this.map);if(n.auto_show!=null){o=n.auto_show}m.onAdd=function(){var s=document.createElement("div");s.style.borderStyle="none";s.style.borderWidth="0px";s.style.position="absolute";s.style.zIndex=100;s.innerHTML=n.content;m.el=s;if(!n.layer){n.layer="overlayLayer"}var r=this.getPanes(),p=r[n.layer],q=["contextmenu","DOMMouseScroll","dblclick","mousedown"];p.appendChild(s);for(var t=0;t<q.length;t++){(function(v,u){google.maps.event.addDomListener(v,u,function(w){if(navigator.userAgent.toLowerCase().indexOf("msie")!=-1&&document.all){w.cancelBubble=true;w.returnValue=false}else{w.stopPropagation()}})})(s,q[t])}if(n.click){r.overlayMouseTarget.appendChild(m.el);google.maps.event.addDomListener(m.el,"click",function(){n.click.apply(m,[m])})}google.maps.event.trigger(this,"ready")};m.draw=function(){var p=this.getProjection(),r=p.fromLatLngToDivPixel(new google.maps.LatLng(n.lat,n.lng));n.horizontalOffset=n.horizontalOffset||0;n.verticalOffset=n.verticalOffset||0;var s=m.el,t=s.children[0],q=t.clientHeight,u=t.clientWidth;switch(n.verticalAlign){case"top":s.style.top=(r.y-q+n.verticalOffset)+"px";break;default:case"middle":s.style.top=(r.y-(q/2)+n.verticalOffset)+"px";break;case"bottom":s.style.top=(r.y+n.verticalOffset)+"px";break}switch(n.horizontalAlign){case"left":s.style.left=(r.x-u+n.horizontalOffset)+"px";break;default:case"center":s.style.left=(r.x-(u/2)+n.horizontalOffset)+"px";break;case"right":s.style.left=(r.x+n.horizontalOffset)+"px";break}s.style.display=o?"block":"none";if(!o){n.show.apply(this,[s])}};m.onRemove=function(){var p=m.el;if(n.remove){n.remove.apply(this,[p])}else{m.el.parentNode.removeChild(m.el);m.el=null}};this.overlays.push(m);return m};j.prototype.removeOverlay=function(m){for(var n=0;n<this.overlays.length;n++){if(this.overlays[n]===m){this.overlays[n].setMap(null);this.overlays.splice(n,1);break}}};j.prototype.removeOverlays=function(){for(var m=0,n;n=this.overlays[m];m++){n.setMap(null)}this.overlays=[]};j.prototype.drawPolyline=function(u){var t=[],r=u.path;if(r.length){if(r[0][0]===undefined){t=r}else{for(var n=0,m;m=r[n];n++){t.push(new google.maps.LatLng(m[0],m[1]))}}}var o={map:this.map,path:t,strokeColor:u.strokeColor,strokeOpacity:u.strokeOpacity,strokeWeight:u.strokeWeight,geodesic:u.geodesic,clickable:true,editable:false,visible:true};if(u.hasOwnProperty("clickable")){o.clickable=u.clickable}if(u.hasOwnProperty("editable")){o.editable=u.editable}if(u.hasOwnProperty("icons")){o.icons=u.icons}if(u.hasOwnProperty("zIndex")){o.zIndex=u.zIndex}var q=new google.maps.Polyline(o);var s=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var p=0;p<s.length;p++){(function(w,v){if(u[v]){google.maps.event.addListener(w,v,function(x){u[v].apply(this,[x])})}})(q,s[p])}this.polylines.push(q);j.fire("polyline_added",q,this);return q};j.prototype.removePolyline=function(m){for(var n=0;n<this.polylines.length;n++){if(this.polylines[n]===m){this.polylines[n].setMap(null);this.polylines.splice(n,1);j.fire("polyline_removed",m,this);break}}};j.prototype.removePolylines=function(){for(var m=0,n;n=this.polylines[m];m++){n.setMap(null)}this.polylines=[]};j.prototype.drawCircle=function(m){m=h({map:this.map,center:new google.maps.LatLng(m.lat,m.lng)},m);delete m.lat;delete m.lng;var n=new google.maps.Circle(m),p=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var o=0;o<p.length;o++){(function(r,q){if(m[q]){google.maps.event.addListener(r,q,function(s){m[q].apply(this,[s])})}})(n,p[o])}this.polygons.push(n);return n};j.prototype.drawRectangle=function(m){m=h({map:this.map},m);var p=new google.maps.LatLngBounds(new google.maps.LatLng(m.bounds[0][0],m.bounds[0][1]),new google.maps.LatLng(m.bounds[1][0],m.bounds[1][1]));m.bounds=p;var n=new google.maps.Rectangle(m),q=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var o=0;o<q.length;o++){(function(s,r){if(m[r]){google.maps.event.addListener(s,r,function(t){m[r].apply(this,[t])})}})(n,q[o])}this.polygons.push(n);return n};j.prototype.drawPolygon=function(m){var p=false;if(m.hasOwnProperty("useGeoJSON")){p=m.useGeoJSON}delete m.useGeoJSON;m=h({map:this.map},m);if(p==false){m.paths=[m.paths.slice(0)]}if(m.paths.length>0){if(m.paths[0].length>0){m.paths=f(k(m.paths,i,p))}}var n=new google.maps.Polygon(m),q=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var o=0;o<q.length;o++){(function(s,r){if(m[r]){google.maps.event.addListener(s,r,function(t){m[r].apply(this,[t])})}})(n,q[o])}this.polygons.push(n);j.fire("polygon_added",n,this);return n};j.prototype.removePolygon=function(n){for(var m=0;m<this.polygons.length;m++){if(this.polygons[m]===n){this.polygons[m].setMap(null);this.polygons.splice(m,1);j.fire("polygon_removed",n,this);break}}};j.prototype.removePolygons=function(){for(var m=0,n;n=this.polygons[m];m++){n.setMap(null)}this.polygons=[]};j.prototype.getFromFusionTables=function(n){var p=n.events;delete n.events;var m=n,o=new google.maps.FusionTablesLayer(m);for(var q in p){(function(s,r){google.maps.event.addListener(s,r,function(t){p[r].apply(this,[t])})})(o,q)}this.layers.push(o);return o};j.prototype.loadFromFusionTables=function(m){var n=this.getFromFusionTables(m);n.setMap(this.map);return n};j.prototype.getFromKML=function(n){var m=n.url,p=n.events;delete n.url;delete n.events;var r=n,o=new google.maps.KmlLayer(m,r);for(var q in p){(function(t,s){google.maps.event.addListener(t,s,function(u){p[s].apply(this,[u])})})(o,q)}this.layers.push(o);return o};j.prototype.loadFromKML=function(m){var n=this.getFromKML(m);n.setMap(this.map);return n};j.prototype.addLayer=function(o,n){n=n||{};var p;switch(o){case"weather":this.singleLayers.weather=p=new google.maps.weather.WeatherLayer();break;case"clouds":this.singleLayers.clouds=p=new google.maps.weather.CloudLayer();break;case"traffic":this.singleLayers.traffic=p=new google.maps.TrafficLayer();break;case"transit":this.singleLayers.transit=p=new google.maps.TransitLayer();break;case"bicycling":this.singleLayers.bicycling=p=new google.maps.BicyclingLayer();break;case"panoramio":this.singleLayers.panoramio=p=new google.maps.panoramio.PanoramioLayer();p.setTag(n.filter);delete n.filter;if(n.click){google.maps.event.addListener(p,"click",function(r){n.click(r);delete n.click})}break;case"places":this.singleLayers.places=p=new google.maps.places.PlacesService(this.map);if(n.search||n.nearbySearch||n.radarSearch){var m={bounds:n.bounds||null,keyword:n.keyword||null,location:n.location||null,name:n.name||null,radius:n.radius||null,rankBy:n.rankBy||null,types:n.types||null};if(n.radarSearch){p.radarSearch(m,n.radarSearch)}if(n.search){p.search(m,n.search)}if(n.nearbySearch){p.nearbySearch(m,n.nearbySearch)}}if(n.textSearch){var q={bounds:n.bounds||null,location:n.location||null,query:n.query||null,radius:n.radius||null};p.textSearch(q,n.textSearch)}break}if(p!==undefined){if(typeof p.setOptions=="function"){p.setOptions(n)}if(typeof p.setMap=="function"){p.setMap(this.map)}return p}};j.prototype.removeLayer=function(n){if(typeof(n)=="string"&&this.singleLayers[n]!==undefined){this.singleLayers[n].setMap(null);delete this.singleLayers[n]}else{for(var m=0;m<this.layers.length;m++){if(this.layers[m]===n){this.layers[m].setMap(null);this.layers.splice(m,1);break}}}};var b,c;j.prototype.getRoutes=function(q){switch(q.travelMode){case"bicycling":b=google.maps.TravelMode.BICYCLING;break;case"transit":b=google.maps.TravelMode.TRANSIT;break;case"driving":b=google.maps.TravelMode.DRIVING;break;default:b=google.maps.TravelMode.WALKING;break}if(q.unitSystem==="imperial"){c=google.maps.UnitSystem.IMPERIAL}else{c=google.maps.UnitSystem.METRIC}var p={avoidHighways:false,avoidTolls:false,optimizeWaypoints:false,waypoints:[]},o=h(p,q);o.origin=/string/.test(typeof q.origin)?q.origin:new google.maps.LatLng(q.origin[0],q.origin[1]);o.destination=/string/.test(typeof q.destination)?q.destination:new google.maps.LatLng(q.destination[0],q.destination[1]);o.travelMode=b;o.unitSystem=c;delete o.callback;delete o.error;var n=this,m=new google.maps.DirectionsService();m.route(o,function(s,t){if(t===google.maps.DirectionsStatus.OK){for(var u in s.routes){if(s.routes.hasOwnProperty(u)){n.routes.push(s.routes[u])}}if(q.callback){q.callback(n.routes)}}else{if(q.error){q.error(s,t)}}})};j.prototype.removeRoutes=function(){this.routes=[]};j.prototype.getElevations=function(n){n=h({locations:[],path:false,samples:256},n);if(n.locations.length>0){if(n.locations[0].length>0){n.locations=f(k([n.locations],i,false))}}var p=n.callback;delete n.callback;var m=new google.maps.ElevationService();if(!n.path){delete n.path;delete n.samples;m.getElevationForLocations(n,function(q,r){if(p&&typeof(p)==="function"){p(q,r)}})}else{var o={path:n.locations,samples:n.samples};m.getElevationAlongPath(o,function(q,r){if(p&&typeof(p)==="function"){p(q,r)}})}};j.prototype.cleanRoute=j.prototype.removePolylines;j.prototype.drawRoute=function(n){var m=this;this.getRoutes({origin:n.origin,destination:n.destination,travelMode:n.travelMode,waypoints:n.waypoints,unitSystem:n.unitSystem,error:n.error,callback:function(o){if(o.length>0){m.drawPolyline({path:o[o.length-1].overview_path,strokeColor:n.strokeColor,strokeOpacity:n.strokeOpacity,strokeWeight:n.strokeWeight});if(n.callback){n.callback(o[o.length-1])}}}})};j.prototype.travelRoute=function(n){if(n.origin&&n.destination){this.getRoutes({origin:n.origin,destination:n.destination,travelMode:n.travelMode,waypoints:n.waypoints,unitSystem:n.unitSystem,error:n.error,callback:function(u){if(u.length>0&&n.start){n.start(u[u.length-1])}if(u.length>0&&n.step){var r=u[u.length-1];if(r.legs.length>0){var q=r.legs[0].steps;for(var s=0,t;t=q[s];s++){t.step_number=s;n.step(t,(r.legs[0].steps.length-1))}}}if(u.length>0&&n.end){n.end(u[u.length-1])}}})}else{if(n.route){if(n.route.legs.length>0){var m=n.route.legs[0].steps;for(var o=0,p;p=m[o];o++){p.step_number=o;n.step(p)}}}}};j.prototype.drawSteppedRoute=function(o){var n=this;if(o.origin&&o.destination){this.getRoutes({origin:o.origin,destination:o.destination,travelMode:o.travelMode,waypoints:o.waypoints,error:o.error,callback:function(v){if(v.length>0&&o.start){o.start(v[v.length-1])}if(v.length>0&&o.step){var s=v[v.length-1];if(s.legs.length>0){var r=s.legs[0].steps;for(var t=0,u;u=r[t];t++){u.step_number=t;n.drawPolyline({path:u.path,strokeColor:o.strokeColor,strokeOpacity:o.strokeOpacity,strokeWeight:o.strokeWeight});o.step(u,(s.legs[0].steps.length-1))}}}if(v.length>0&&o.end){o.end(v[v.length-1])}}})}else{if(o.route){if(o.route.legs.length>0){var m=o.route.legs[0].steps;for(var p=0,q;q=m[p];p++){q.step_number=p;n.drawPolyline({path:q.path,strokeColor:o.strokeColor,strokeOpacity:o.strokeOpacity,strokeWeight:o.strokeWeight});o.step(q)}}}}};j.Route=function(m){this.origin=m.origin;this.destination=m.destination;this.waypoints=m.waypoints;this.map=m.map;this.route=m.route;this.step_count=0;this.steps=this.route.legs[0].steps;this.steps_length=this.steps.length;this.polyline=this.map.drawPolyline({path:new google.maps.MVCArray(),strokeColor:m.strokeColor,strokeOpacity:m.strokeOpacity,strokeWeight:m.strokeWeight}).getPath()};j.Route.prototype.getRoute=function(n){var m=this;this.map.getRoutes({origin:this.origin,destination:this.destination,travelMode:n.travelMode,waypoints:this.waypoints||[],error:n.error,callback:function(){m.route=e[0];if(n.callback){n.callback.call(m)}}})};j.Route.prototype.back=function(){if(this.step_count>0){this.step_count--;var n=this.route.legs[0].steps[this.step_count].path;for(var m in n){if(n.hasOwnProperty(m)){this.polyline.pop()}}}};j.Route.prototype.forward=function(){if(this.step_count<this.steps_length){var n=this.route.legs[0].steps[this.step_count].path;for(var m in n){if(n.hasOwnProperty(m)){this.polyline.push(n[m])}}this.step_count++}};j.prototype.checkGeofence=function(n,m,o){return o.containsLatLng(new google.maps.LatLng(n,m))};j.prototype.checkMarkerGeofence=function(m,o){if(m.fences){for(var n=0,p;p=m.fences[n];n++){var q=m.getPosition();if(!this.checkGeofence(q.lat(),q.lng(),p)){o(m,p)}}}};j.prototype.toImage=function(n){var n=n||{},p={};p.size=n.size||[this.el.clientWidth,this.el.clientHeight];p.lat=this.getCenter().lat();p.lng=this.getCenter().lng();if(this.markers.length>0){p.markers=[];for(var o=0;o<this.markers.length;o++){p.markers.push({lat:this.markers[o].getPosition().lat(),lng:this.markers[o].getPosition().lng()})}}if(this.polylines.length>0){var m=this.polylines[0];p.polyline={};p.polyline["path"]=google.maps.geometry.encoding.encodePath(m.getPath());p.polyline["strokeColor"]=m.strokeColor;p.polyline["strokeOpacity"]=m.strokeOpacity;p.polyline["strokeWeight"]=m.strokeWeight}return j.staticMapURL(p)};j.staticMapURL=function(n){var t=[],L,o="http://maps.googleapis.com/maps/api/staticmap";if(n.url){o=n.url;delete n.url}o+="?";var I=n.markers;delete n.markers;if(!I&&n.marker){I=[n.marker];delete n.marker}var w=n.styles;delete n.styles;var B=n.polyline;delete n.polyline;if(n.center){t.push("center="+n.center);delete n.center}else{if(n.address){t.push("center="+n.address);delete n.address}else{if(n.lat){t.push(["center=",n.lat,",",n.lng].join(""));delete n.lat;delete n.lng}else{if(n.visible){var m=encodeURI(n.visible.join("|"));t.push("visible="+m)}}}}var z=n.size;if(z){if(z.join){z=z.join("x")}delete n.size}else{z="630x300"}t.push("size="+z);if(!n.zoom&&n.zoom!==false){n.zoom=15}var J=n.hasOwnProperty("sensor")?!!n.sensor:true;delete n.sensor;t.push("sensor="+J);for(var u in n){if(n.hasOwnProperty(u)){t.push(u+"="+n[u])}}if(I){var v,x;for(var F=0;L=I[F];F++){v=[];if(L.size&&L.size!=="normal"){v.push("size:"+L.size);delete L.size}else{if(L.icon){v.push("icon:"+encodeURI(L.icon));delete L.icon}}if(L.color){v.push("color:"+L.color.replace("#","0x"));delete L.color}if(L.label){v.push("label:"+L.label[0].toUpperCase());delete L.label}x=(L.address?L.address:L.lat+","+L.lng);delete L.address;delete L.lat;delete L.lng;for(var u in L){if(L.hasOwnProperty(u)){v.push(u+":"+L[u])}}if(v.length||F===0){v.push(x);v=v.join("|");t.push("markers="+encodeURI(v))}else{v=t.pop()+encodeURI("|"+x);t.push(v)}}}if(w){for(var F=0;F<w.length;F++){var y=[];if(w[F].featureType){y.push("feature:"+w[F].featureType.toLowerCase())}if(w[F].elementType){y.push("element:"+w[F].elementType.toLowerCase())}for(var E=0;E<w[F].stylers.length;E++){for(var C in w[F].stylers[E]){var G=w[F].stylers[E][C];if(C=="hue"||C=="color"){G="0x"+G.substring(1)}y.push(C+":"+G)}}var s=y.join("|");if(s!=""){t.push("style="+s)}}}function H(p,M){if(p[0]==="#"){p=p.replace("#","0x");if(M){M=parseFloat(M);M=Math.min(1,Math.max(M,0));if(M===0){return"0x00000000"}M=(M*255).toString(16);if(M.length===1){M+=M}p=p.slice(0,8)+M}}return p}if(B){L=B;B=[];if(L.strokeWeight){B.push("weight:"+parseInt(L.strokeWeight,10))}if(L.strokeColor){var D=H(L.strokeColor,L.strokeOpacity);B.push("color:"+D)}if(L.fillColor){var K=H(L.fillColor,L.fillOpacity);B.push("fillcolor:"+K)}var A=L.path;if(A.join){for(var E=0,r;r=A[E];E++){B.push(r.join(","))}}else{B.push("enc:"+A)}B=B.join("|");t.push("path="+encodeURI(B))}var q=window.devicePixelRatio||1;t.push("scale="+q);t=t.join("&");return o+t};j.prototype.addMapType=function(m,n){if(n.hasOwnProperty("getTileUrl")&&typeof(n.getTileUrl)=="function"){n.tileSize=n.tileSize||new google.maps.Size(256,256);var o=new google.maps.ImageMapType(n);this.map.mapTypes.set(m,o)}else{throw"'getTileUrl' function required."}};j.prototype.addOverlayMapType=function(m){if(m.hasOwnProperty("getTile")&&typeof(m.getTile)=="function"){var n=m.index;delete m.index;this.map.overlayMapTypes.insertAt(n,m)}else{throw"'getTile' function required."}};j.prototype.removeOverlayMapType=function(m){this.map.overlayMapTypes.removeAt(m)};j.prototype.addStyle=function(n){var m=new google.maps.StyledMapType(n.styles,{name:n.styledMapName});this.map.mapTypes.set(n.mapTypeId,m)};j.prototype.setStyle=function(m){this.map.setMapTypeId(m)};j.prototype.createPanorama=function(m){if(!m.hasOwnProperty("lat")||!m.hasOwnProperty("lng")){m.lat=this.getCenter().lat();m.lng=this.getCenter().lng()}this.panorama=j.createPanorama(m);this.map.setStreetView(this.panorama);return this.panorama};j.createPanorama=function(n){var q=a(n.el,n.context);n.position=new google.maps.LatLng(n.lat,n.lng);delete n.el;delete n.context;delete n.lat;delete n.lng;var r=["closeclick","links_changed","pano_changed","position_changed","pov_changed","resize","visible_changed"],m=h({visible:true},n);for(var p=0;p<r.length;p++){delete m[r[p]]}var o=new google.maps.StreetViewPanorama(q,m);for(var p=0;p<r.length;p++){(function(t,s){if(n[s]){google.maps.event.addListener(t,s,function(){n[s].apply(this)})}})(o,r[p])}return o};j.prototype.on=function(n,m){return j.on(n,this,m)};j.prototype.off=function(m){j.off(m,this)};j.custom_events=["marker_added","marker_removed","polyline_added","polyline_removed","polygon_added","polygon_removed","geolocated","geolocation_failed"];j.on=function(p,m,o){if(j.custom_events.indexOf(p)==-1){if(m instanceof j){m=m.map}return google.maps.event.addListener(m,p,o)}else{var n={handler:o,eventName:p};m.registered_events[p]=m.registered_events[p]||[];m.registered_events[p].push(n);return n}};j.off=function(n,m){if(j.custom_events.indexOf(n)==-1){if(m instanceof j){m=m.map}google.maps.event.clearListeners(m,n)}else{m.registered_events[n]=[]}};j.fire=function(q,m,p){if(j.custom_events.indexOf(q)==-1){google.maps.event.trigger(m,q,Array.prototype.slice.apply(arguments).slice(2))}else{if(q in p.registered_events){var o=p.registered_events[q];for(var n=0;n<o.length;n++){(function(t,s,r){t.apply(s,[r])})(o[n]["handler"],p,m)}}}};j.geolocate=function(m){var n=m.always||m.complete;if(navigator.geolocation){navigator.geolocation.getCurrentPosition(function(o){m.success(o);if(n){n()}},function(o){m.error(o);if(n){n()}},m.options)}else{m.not_supported();if(n){n()}}};j.geocode=function(m){this.geocoder=new google.maps.Geocoder();var n=m.callback;if(m.hasOwnProperty("lat")&&m.hasOwnProperty("lng")){m.latLng=new google.maps.LatLng(m.lat,m.lng)}delete m.lat;delete m.lng;delete m.callback;this.geocoder.geocode(m,function(p,o){n(p,o)})};if(!google.maps.Polygon.prototype.getBounds){google.maps.Polygon.prototype.getBounds=function(o){var n=new google.maps.LatLngBounds();var s=this.getPaths();var r;for(var q=0;q<s.getLength();q++){r=s.getAt(q);for(var m=0;m<r.getLength();m++){n.extend(r.getAt(m))}}return n}}if(!google.maps.Polygon.prototype.containsLatLng){google.maps.Polygon.prototype.containsLatLng=function(r){var m=this.getBounds();if(m!==null&&!m.contains(r)){return false}var o=false;var n=this.getPaths().getLength();for(var q=0;q<n;q++){var x=this.getPaths().getAt(q);var u=x.getLength();var s=u-1;for(var t=0;t<u;t++){var w=x.getAt(t);var v=x.getAt(s);if(w.lng()<r.lng()&&v.lng()>=r.lng()||v.lng()<r.lng()&&w.lng()>=r.lng()){if(w.lat()+(r.lng()-w.lng())/(v.lng()-w.lng())*(v.lat()-w.lat())<r.lat()){o=!o}}s=t}}return o}}if(!google.maps.Circle.prototype.containsLatLng){google.maps.Circle.prototype.containsLatLng=function(m){if(google.maps.geometry){return google.maps.geometry.spherical.computeDistanceBetween(this.getCenter(),m)<=this.getRadius()}else{return true}}}google.maps.LatLngBounds.prototype.containsLatLng=function(m){return this.contains(m)};google.maps.Marker.prototype.setFences=function(m){this.fences=m};google.maps.Marker.prototype.addFence=function(m){this.fences.push(m)};google.maps.Marker.prototype.getId=function(){return this["__gm_id"]};if(!Array.prototype.indexOf){Array.prototype.indexOf=function(p){if(this==null){throw new TypeError()}var q=Object(this);var m=q.length>>>0;if(m===0){return -1}var r=0;if(arguments.length>1){r=Number(arguments[1]);if(r!=r){r=0}else{if(r!=0&&r!=Infinity&&r!=-Infinity){r=(r>0||-1)*Math.floor(Math.abs(r))}}}if(r>=m){return -1}var o=r>=0?r:Math.max(m-Math.abs(r),0);for(;o<m;o++){if(o in q&&q[o]===p){return o}}return -1}}return j}));