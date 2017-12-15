/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("var MapRenderer = function MapRenderer (selector) {\n    this.selector = selector\n    this.wrld3dApiKey = window.WRLD_3D_API_KEY\n    this.mapboxKey = window.MAPBOX_KEY\n    this.markers = []\n    this.instance = null\n    this.lat = null\n    this.lng = null\n\n    this.createInstance()\n};\n\nMapRenderer.prototype.createInstance = function createInstance () {\n    if (this.wrld3dApiKey) {\n        this.instance = L.Wrld.map(this.selector, this.wrld3dApiKey, {\n            indoorsEnabled: true,\n        })\n\n        this.listenFloorControls()\n        return this\n    }\n\n    this.instance = L.map(this.selector)\n\n    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + this.mapboxKey, {\n        attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',\n        maxZoom: 18,\n        id: 'mapbox.streets',\n        accessToken: this.mapboxKey\n    }).addTo(this.instance)\n\n    return this\n};\n\nMapRenderer.prototype.listenFloorControls = function listenFloorControls () {\n        var this$1 = this;\n\n    $('.map-area__topFloor').on('click', function () {\n        var indoorMap = this$1.instance.indoors.getActiveIndoorMap()\n        if (indoorMap) {\n            this$1.instance.indoors.setFloor(indoorMap.getFloorCount() - 1)\n        }\n    })\n\n    $('.map-area__moveUp').on('click', function () {\n        this$1.instance.indoors.moveUp()\n    })\n\n    $('.map-area__moveDown').on('click', function () {\n        this$1.instance.indoors.moveDown()\n    })\n};\n\nMapRenderer.prototype.setLatLng = function setLatLng (lat, lng) {\n    this.lat = parseFloat(lat)\n    this.lng = parseFloat(lng)\n\n    return this\n};\n\nMapRenderer.prototype.loadMarkers = function loadMarkers (markers, options) {\n        var this$1 = this;\n\n    options = Object.assign({}, {\n        merge: false,\n        popup: true,\n        tooltip: true,\n    }, options)\n\n    if (!options.merge) {\n        this.removeMarkers()\n    }\n\n    markers.forEach(function (m) {\n        this$1.addMapMarker(m, options)\n    })\n\n    return this\n};\n\nMapRenderer.prototype.addMapMarker = function addMapMarker (item, options) {\n\n    if (!$.isNumeric(item.latitude) || !$.isNumeric(item.longitude)) {\n        return\n    }\n\n    var marker = L.marker([item.latitude, item.longitude])\n\n    // Add a tooltip to the marker\n    if (options.tooltip) {\n        marker.bindTooltip(item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })\n    }\n\n    // Add a popup with marker's information\n    if (options.popup) {\n        var popup = '<button class=\"map-popup-link\" onclick=\"window.location.href=\\'' + item.url + '\\'\">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></button><p><em>' + item.exchangeTypes + '</em></p>'\n        marker.bindPopup(popup)\n\n        var popup = L.DomUtil.create('div', 'map-popup')\n        popup.innerHTML = '<div>' + item.image + '</div><a href=\"' + item.url + '\" class=\"map-popup-link\">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></a><p><em>' + item.exchangeTypes + '</em></p>'\n\n        marker.bindPopup(popup)\n    }\n\n    this.markers.push(marker)\n    marker.addTo(this.instance)\n\n    return marker\n};\n\nMapRenderer.prototype.goToLinkListener = function goToLinkListener (link) {\n    window.location.href = link\n};\n\nMapRenderer.prototype.removeMarkers = function removeMarkers () {\n    this.markers.forEach(function (m) {\n        m.remove()\n    })\n\n    this.markers = []\n};\n\nMapRenderer.prototype.center = function center () {\n    if (this.lat && this.lng) {\n        this.instance.setView(new L.LatLng(this.lat, this.lng), 18)\n        return this\n    }\n\n    var points = []\n\n    this.markers.forEach(function (mk) {\n        points.push([mk.getLatLng().lat, mk.getLatLng().lng])\n    })\n\n    if (points.length === 0) {\n        return this\n    }\n\n    this.instance.fitBounds(points)\n    return this\n};\n\n// ---------------------------------------------------------\n\nwindow.createMapRenderer = function (selector) {\n    return new MapRenderer(selector)\n}\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL21hcHMuanM/ODE1MCJdLCJzb3VyY2VzQ29udGVudCI6WyJjbGFzcyBNYXBSZW5kZXJlciB7XG4gICAgY29uc3RydWN0b3IgKHNlbGVjdG9yKSB7XG4gICAgICAgIHRoaXMuc2VsZWN0b3IgPSBzZWxlY3RvclxuICAgICAgICB0aGlzLndybGQzZEFwaUtleSA9IHdpbmRvdy5XUkxEXzNEX0FQSV9LRVlcbiAgICAgICAgdGhpcy5tYXBib3hLZXkgPSB3aW5kb3cuTUFQQk9YX0tFWVxuICAgICAgICB0aGlzLm1hcmtlcnMgPSBbXVxuICAgICAgICB0aGlzLmluc3RhbmNlID0gbnVsbFxuICAgICAgICB0aGlzLmxhdCA9IG51bGxcbiAgICAgICAgdGhpcy5sbmcgPSBudWxsXG5cbiAgICAgICAgdGhpcy5jcmVhdGVJbnN0YW5jZSgpXG4gICAgfVxuXG4gICAgY3JlYXRlSW5zdGFuY2UgKCkge1xuICAgICAgICBpZiAodGhpcy53cmxkM2RBcGlLZXkpIHtcbiAgICAgICAgICAgIHRoaXMuaW5zdGFuY2UgPSBMLldybGQubWFwKHRoaXMuc2VsZWN0b3IsIHRoaXMud3JsZDNkQXBpS2V5LCB7XG4gICAgICAgICAgICAgICAgaW5kb29yc0VuYWJsZWQ6IHRydWUsXG4gICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICB0aGlzLmxpc3RlbkZsb29yQ29udHJvbHMoKVxuICAgICAgICAgICAgcmV0dXJuIHRoaXNcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuaW5zdGFuY2UgPSBMLm1hcCh0aGlzLnNlbGVjdG9yKVxuXG4gICAgICAgIEwudGlsZUxheWVyKCdodHRwczovL2FwaS50aWxlcy5tYXBib3guY29tL3Y0L3tpZH0ve3p9L3t4fS97eX0ucG5nP2FjY2Vzc190b2tlbj0nICsgdGhpcy5tYXBib3hLZXksIHtcbiAgICAgICAgICAgIGF0dHJpYnV0aW9uOiAnTWFwIGRhdGEgJmNvcHk7IDxhIGhyZWY9XCJodHRwOi8vb3BlbnN0cmVldG1hcC5vcmdcIj5PcGVuU3RyZWV0TWFwPC9hPiBjb250cmlidXRvcnMsIDxhIGhyZWY9XCJodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9saWNlbnNlcy9ieS1zYS8yLjAvXCI+Q0MtQlktU0E8L2E+LCBJbWFnZXJ5IMKpIDxhIGhyZWY9XCJodHRwOi8vbWFwYm94LmNvbVwiPk1hcGJveDwvYT4nLFxuICAgICAgICAgICAgbWF4Wm9vbTogMTgsXG4gICAgICAgICAgICBpZDogJ21hcGJveC5zdHJlZXRzJyxcbiAgICAgICAgICAgIGFjY2Vzc1Rva2VuOiB0aGlzLm1hcGJveEtleVxuICAgICAgICB9KS5hZGRUbyh0aGlzLmluc3RhbmNlKVxuXG4gICAgICAgIHJldHVybiB0aGlzXG4gICAgfVxuXG4gICAgbGlzdGVuRmxvb3JDb250cm9scyAoKSB7XG4gICAgICAgICQoJy5tYXAtYXJlYV9fdG9wRmxvb3InKS5vbignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgICAgICBjb25zdCBpbmRvb3JNYXAgPSB0aGlzLmluc3RhbmNlLmluZG9vcnMuZ2V0QWN0aXZlSW5kb29yTWFwKClcbiAgICAgICAgICAgIGlmIChpbmRvb3JNYXApIHtcbiAgICAgICAgICAgICAgICB0aGlzLmluc3RhbmNlLmluZG9vcnMuc2V0Rmxvb3IoaW5kb29yTWFwLmdldEZsb29yQ291bnQoKSAtIDEpXG4gICAgICAgICAgICB9XG4gICAgICAgIH0pXG5cbiAgICAgICAgJCgnLm1hcC1hcmVhX19tb3ZlVXAnKS5vbignY2xpY2snLCAoKSA9PiB7XG4gICAgICAgICAgICB0aGlzLmluc3RhbmNlLmluZG9vcnMubW92ZVVwKClcbiAgICAgICAgfSlcblxuICAgICAgICAkKCcubWFwLWFyZWFfX21vdmVEb3duJykub24oJ2NsaWNrJywgKCkgPT4ge1xuICAgICAgICAgICAgdGhpcy5pbnN0YW5jZS5pbmRvb3JzLm1vdmVEb3duKClcbiAgICAgICAgfSlcbiAgICB9XG5cbiAgICBzZXRMYXRMbmcgKGxhdCwgbG5nKSB7XG4gICAgICAgIHRoaXMubGF0ID0gcGFyc2VGbG9hdChsYXQpXG4gICAgICAgIHRoaXMubG5nID0gcGFyc2VGbG9hdChsbmcpXG5cbiAgICAgICAgcmV0dXJuIHRoaXNcbiAgICB9XG5cbiAgICBsb2FkTWFya2VycyAobWFya2Vycywgb3B0aW9ucykge1xuICAgICAgICBvcHRpb25zID0gT2JqZWN0LmFzc2lnbih7fSwge1xuICAgICAgICAgICAgbWVyZ2U6IGZhbHNlLFxuICAgICAgICAgICAgcG9wdXA6IHRydWUsXG4gICAgICAgICAgICB0b29sdGlwOiB0cnVlLFxuICAgICAgICB9LCBvcHRpb25zKVxuXG4gICAgICAgIGlmICghb3B0aW9ucy5tZXJnZSkge1xuICAgICAgICAgICAgdGhpcy5yZW1vdmVNYXJrZXJzKClcbiAgICAgICAgfVxuXG4gICAgICAgIG1hcmtlcnMuZm9yRWFjaCgobSkgPT4ge1xuICAgICAgICAgICAgdGhpcy5hZGRNYXBNYXJrZXIobSwgb3B0aW9ucylcbiAgICAgICAgfSlcblxuICAgICAgICByZXR1cm4gdGhpc1xuICAgIH1cblxuICAgIGFkZE1hcE1hcmtlciAoaXRlbSwgb3B0aW9ucykge1xuXG4gICAgICAgIGlmICghJC5pc051bWVyaWMoaXRlbS5sYXRpdHVkZSkgfHwgISQuaXNOdW1lcmljKGl0ZW0ubG9uZ2l0dWRlKSkge1xuICAgICAgICAgICAgcmV0dXJuXG4gICAgICAgIH1cblxuICAgICAgICB2YXIgbWFya2VyID0gTC5tYXJrZXIoW2l0ZW0ubGF0aXR1ZGUsIGl0ZW0ubG9uZ2l0dWRlXSlcblxuICAgICAgICAvLyBBZGQgYSB0b29sdGlwIHRvIHRoZSBtYXJrZXJcbiAgICAgICAgaWYgKG9wdGlvbnMudG9vbHRpcCkge1xuICAgICAgICAgICAgbWFya2VyLmJpbmRUb29sdGlwKGl0ZW0uZGlzcGxheV9uYW1lICsgJyAnICsgaXRlbS5uYXR1cmFsX3Bvc3RfdHlwZSArICcgPGI+JyArIGl0ZW0udGl0bGUgKyAnPC9iPicsIHsgcGVybWFuZW50OiBmYWxzZSB9KVxuICAgICAgICB9XG5cbiAgICAgICAgLy8gQWRkIGEgcG9wdXAgd2l0aCBtYXJrZXIncyBpbmZvcm1hdGlvblxuICAgICAgICBpZiAob3B0aW9ucy5wb3B1cCkge1xuICAgICAgICAgICAgdmFyIHBvcHVwID0gJzxidXR0b24gY2xhc3M9XCJtYXAtcG9wdXAtbGlua1wiIG9uY2xpY2s9XCJ3aW5kb3cubG9jYXRpb24uaHJlZj1cXCcnICsgaXRlbS51cmwgKyAnXFwnXCI+JyArIGl0ZW0uZGlzcGxheV9uYW1lICsgJyAnICsgaXRlbS5uYXR1cmFsX3Bvc3RfdHlwZSArICcgPGI+JyArIGl0ZW0udGl0bGUgKyAnPC9iPjwvYnV0dG9uPjxwPjxlbT4nICsgaXRlbS5leGNoYW5nZVR5cGVzICsgJzwvZW0+PC9wPidcbiAgICAgICAgICAgIG1hcmtlci5iaW5kUG9wdXAocG9wdXApXG5cbiAgICAgICAgICAgIHZhciBwb3B1cCA9IEwuRG9tVXRpbC5jcmVhdGUoJ2RpdicsICdtYXAtcG9wdXAnKVxuICAgICAgICAgICAgcG9wdXAuaW5uZXJIVE1MID0gJzxkaXY+JyArIGl0ZW0uaW1hZ2UgKyAnPC9kaXY+PGEgaHJlZj1cIicgKyBpdGVtLnVybCArICdcIiBjbGFzcz1cIm1hcC1wb3B1cC1saW5rXCI+JyArIGl0ZW0uZGlzcGxheV9uYW1lICsgJyAnICsgaXRlbS5uYXR1cmFsX3Bvc3RfdHlwZSArICcgPGI+JyArIGl0ZW0udGl0bGUgKyAnPC9iPjwvYT48cD48ZW0+JyArIGl0ZW0uZXhjaGFuZ2VUeXBlcyArICc8L2VtPjwvcD4nXG5cbiAgICAgICAgICAgIG1hcmtlci5iaW5kUG9wdXAocG9wdXApXG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLm1hcmtlcnMucHVzaChtYXJrZXIpXG4gICAgICAgIG1hcmtlci5hZGRUbyh0aGlzLmluc3RhbmNlKVxuXG4gICAgICAgIHJldHVybiBtYXJrZXJcbiAgICB9XG5cbiAgICBnb1RvTGlua0xpc3RlbmVyIChsaW5rKSB7XG4gICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gbGlua1xuICAgIH1cblxuICAgIHJlbW92ZU1hcmtlcnMgKCkge1xuICAgICAgICB0aGlzLm1hcmtlcnMuZm9yRWFjaCgobSkgPT4ge1xuICAgICAgICAgICAgbS5yZW1vdmUoKVxuICAgICAgICB9KVxuXG4gICAgICAgIHRoaXMubWFya2VycyA9IFtdXG4gICAgfVxuXG4gICAgY2VudGVyICgpIHtcbiAgICAgICAgaWYgKHRoaXMubGF0ICYmIHRoaXMubG5nKSB7XG4gICAgICAgICAgICB0aGlzLmluc3RhbmNlLnNldFZpZXcobmV3IEwuTGF0TG5nKHRoaXMubGF0LCB0aGlzLmxuZyksIDE4KVxuICAgICAgICAgICAgcmV0dXJuIHRoaXNcbiAgICAgICAgfVxuXG4gICAgICAgIHZhciBwb2ludHMgPSBbXVxuXG4gICAgICAgIHRoaXMubWFya2Vycy5mb3JFYWNoKChtaykgPT4ge1xuICAgICAgICAgICAgcG9pbnRzLnB1c2goW21rLmdldExhdExuZygpLmxhdCwgbWsuZ2V0TGF0TG5nKCkubG5nXSlcbiAgICAgICAgfSlcblxuICAgICAgICBpZiAocG9pbnRzLmxlbmd0aCA9PT0gMCkge1xuICAgICAgICAgICAgcmV0dXJuIHRoaXNcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuaW5zdGFuY2UuZml0Qm91bmRzKHBvaW50cylcbiAgICAgICAgcmV0dXJuIHRoaXNcbiAgICB9XG59XG5cbi8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxuXG53aW5kb3cuY3JlYXRlTWFwUmVuZGVyZXIgPSBmdW5jdGlvbiAoc2VsZWN0b3IpIHtcbiAgICByZXR1cm4gbmV3IE1hcFJlbmRlcmVyKHNlbGVjdG9yKVxufVxuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHJlc291cmNlcy9hc3NldHMvanMvbWFwcy5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFJQTtBQUNBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9");

/***/ }
/******/ ]);