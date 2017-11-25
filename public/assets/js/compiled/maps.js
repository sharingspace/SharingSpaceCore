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

eval("var MapRenderer = function MapRenderer (selector) {\n    this.selector = selector\n    this.wrld3dApiKey = window.WRLD_3D_API_KEY\n    this.mapboxKey = window.MAPBOX_KEY\n    this.markers = []\n    this.instance = null\n    this.lat = null\n    this.lng = null\n\n    this.createInstance()\n};\n\nMapRenderer.prototype.createInstance = function createInstance () {\n    if (this.wrld3dApiKey) {\n        this.instance = L.Wrld.map(this.selector, this.wrld3dApiKey)\n        return this\n    }\n\n    this.instance = L.map(this.selector)\n\n    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + this.mapboxKey, {\n        attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',\n        maxZoom: 18,\n        id: 'mapbox.streets',\n        accessToken: this.mapboxKey\n    }).addTo(this.instance)\n\n    return this\n};\n\nMapRenderer.prototype.setLatLng = function setLatLng (lat, lng) {\n    this.lat = parseFloat(lat)\n    this.lng = parseFloat(lng)\n\n    return this\n};\n\nMapRenderer.prototype.loadMarkers = function loadMarkers (markers, options) {\n        var this$1 = this;\n\n    options = Object.assign({}, {\n        merge: false,\n        popup: true,\n        tooltip: true,\n    }, options)\n\n    if (!options.merge) {\n        this.removeMarkers()\n    }\n\n    markers.forEach(function (m) {\n        this$1.addMapMarker(m, options)\n    })\n\n    return this\n};\n\nMapRenderer.prototype.addMapMarker = function addMapMarker (item, options) {\n\n    if (!$.isNumeric(item.latitude) || !$.isNumeric(item.longitude)) {\n        return\n    }\n\n    var marker = L.marker([item.latitude, item.longitude])\n\n    // Add a tooltip to the marker\n    if (options.tooltip) {\n        marker.bindTooltip(item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })\n    }\n\n    // Add a popup with marker's information\n    if (options.popup) {\n        var popup = '<button class=\"map-popup-link\" onclick=\"window.location.href=\\'' + item.url + '\\'\">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></button><p><em>' + item.exchangeTypes + '</em></p>'\n        marker.bindPopup(popup)\n\n        var popup = L.DomUtil.create('div', 'map-popup')\n        popup.innerHTML = '<div>' + item.image + '</div><a href=\"' + item.url + '\" class=\"map-popup-link\">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></a><p><em>' + item.exchangeTypes + '</em></p>'\n\n        marker.bindPopup(popup)\n    }\n\n    this.markers.push(marker)\n    marker.addTo(this.instance)\n\n    return marker\n};\n\nMapRenderer.prototype.goToLinkListener = function goToLinkListener (link) {\n    window.location.href = link\n};\n\nMapRenderer.prototype.removeMarkers = function removeMarkers () {\n    this.markers.forEach(function (m) {\n        m.remove()\n    })\n\n    this.markers = []\n};\n\nMapRenderer.prototype.center = function center () {\n    if (this.lat && this.lng) {\n        this.instance.setView(new L.LatLng(this.lat, this.lng), 18)\n        return this\n    }\n\n    var points = []\n\n    this.markers.forEach(function (mk) {\n        points.push([mk.getLatLng().lat, mk.getLatLng().lng])\n    })\n\n    if (points.length === 0) {\n        return this\n    }\n\n    this.instance.fitBounds(points)\n    return this\n};\n\n// ---------------------------------------------------------\n\nwindow.createMapRenderer = function (selector) {\n    return new MapRenderer(selector)\n}\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL21hcHMuanM/ODE1MCJdLCJzb3VyY2VzQ29udGVudCI6WyJjbGFzcyBNYXBSZW5kZXJlciB7XG4gICAgY29uc3RydWN0b3IgKHNlbGVjdG9yKSB7XG4gICAgICAgIHRoaXMuc2VsZWN0b3IgPSBzZWxlY3RvclxuICAgICAgICB0aGlzLndybGQzZEFwaUtleSA9IHdpbmRvdy5XUkxEXzNEX0FQSV9LRVlcbiAgICAgICAgdGhpcy5tYXBib3hLZXkgPSB3aW5kb3cuTUFQQk9YX0tFWVxuICAgICAgICB0aGlzLm1hcmtlcnMgPSBbXVxuICAgICAgICB0aGlzLmluc3RhbmNlID0gbnVsbFxuICAgICAgICB0aGlzLmxhdCA9IG51bGxcbiAgICAgICAgdGhpcy5sbmcgPSBudWxsXG5cbiAgICAgICAgdGhpcy5jcmVhdGVJbnN0YW5jZSgpXG4gICAgfVxuXG4gICAgY3JlYXRlSW5zdGFuY2UgKCkge1xuICAgICAgICBpZiAodGhpcy53cmxkM2RBcGlLZXkpIHtcbiAgICAgICAgICAgIHRoaXMuaW5zdGFuY2UgPSBMLldybGQubWFwKHRoaXMuc2VsZWN0b3IsIHRoaXMud3JsZDNkQXBpS2V5KVxuICAgICAgICAgICAgcmV0dXJuIHRoaXNcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuaW5zdGFuY2UgPSBMLm1hcCh0aGlzLnNlbGVjdG9yKVxuXG4gICAgICAgIEwudGlsZUxheWVyKCdodHRwczovL2FwaS50aWxlcy5tYXBib3guY29tL3Y0L3tpZH0ve3p9L3t4fS97eX0ucG5nP2FjY2Vzc190b2tlbj0nICsgdGhpcy5tYXBib3hLZXksIHtcbiAgICAgICAgICAgIGF0dHJpYnV0aW9uOiAnTWFwIGRhdGEgJmNvcHk7IDxhIGhyZWY9XCJodHRwOi8vb3BlbnN0cmVldG1hcC5vcmdcIj5PcGVuU3RyZWV0TWFwPC9hPiBjb250cmlidXRvcnMsIDxhIGhyZWY9XCJodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9saWNlbnNlcy9ieS1zYS8yLjAvXCI+Q0MtQlktU0E8L2E+LCBJbWFnZXJ5IMKpIDxhIGhyZWY9XCJodHRwOi8vbWFwYm94LmNvbVwiPk1hcGJveDwvYT4nLFxuICAgICAgICAgICAgbWF4Wm9vbTogMTgsXG4gICAgICAgICAgICBpZDogJ21hcGJveC5zdHJlZXRzJyxcbiAgICAgICAgICAgIGFjY2Vzc1Rva2VuOiB0aGlzLm1hcGJveEtleVxuICAgICAgICB9KS5hZGRUbyh0aGlzLmluc3RhbmNlKVxuXG4gICAgICAgIHJldHVybiB0aGlzXG4gICAgfVxuXG4gICAgc2V0TGF0TG5nIChsYXQsIGxuZykge1xuICAgICAgICB0aGlzLmxhdCA9IHBhcnNlRmxvYXQobGF0KVxuICAgICAgICB0aGlzLmxuZyA9IHBhcnNlRmxvYXQobG5nKVxuXG4gICAgICAgIHJldHVybiB0aGlzXG4gICAgfVxuXG4gICAgbG9hZE1hcmtlcnMgKG1hcmtlcnMsIG9wdGlvbnMpIHtcbiAgICAgICAgb3B0aW9ucyA9IE9iamVjdC5hc3NpZ24oe30sIHtcbiAgICAgICAgICAgIG1lcmdlOiBmYWxzZSxcbiAgICAgICAgICAgIHBvcHVwOiB0cnVlLFxuICAgICAgICAgICAgdG9vbHRpcDogdHJ1ZSxcbiAgICAgICAgfSwgb3B0aW9ucylcblxuICAgICAgICBpZiAoIW9wdGlvbnMubWVyZ2UpIHtcbiAgICAgICAgICAgIHRoaXMucmVtb3ZlTWFya2VycygpXG4gICAgICAgIH1cblxuICAgICAgICBtYXJrZXJzLmZvckVhY2goKG0pID0+IHtcbiAgICAgICAgICAgIHRoaXMuYWRkTWFwTWFya2VyKG0sIG9wdGlvbnMpXG4gICAgICAgIH0pXG5cbiAgICAgICAgcmV0dXJuIHRoaXNcbiAgICB9XG5cbiAgICBhZGRNYXBNYXJrZXIgKGl0ZW0sIG9wdGlvbnMpIHtcblxuICAgICAgICBpZiAoISQuaXNOdW1lcmljKGl0ZW0ubGF0aXR1ZGUpIHx8ICEkLmlzTnVtZXJpYyhpdGVtLmxvbmdpdHVkZSkpIHtcbiAgICAgICAgICAgIHJldHVyblxuICAgICAgICB9XG5cbiAgICAgICAgdmFyIG1hcmtlciA9IEwubWFya2VyKFtpdGVtLmxhdGl0dWRlLCBpdGVtLmxvbmdpdHVkZV0pXG5cbiAgICAgICAgLy8gQWRkIGEgdG9vbHRpcCB0byB0aGUgbWFya2VyXG4gICAgICAgIGlmIChvcHRpb25zLnRvb2x0aXApIHtcbiAgICAgICAgICAgIG1hcmtlci5iaW5kVG9vbHRpcChpdGVtLmRpc3BsYXlfbmFtZSArICcgJyArIGl0ZW0ubmF0dXJhbF9wb3N0X3R5cGUgKyAnIDxiPicgKyBpdGVtLnRpdGxlICsgJzwvYj4nLCB7IHBlcm1hbmVudDogZmFsc2UgfSlcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIEFkZCBhIHBvcHVwIHdpdGggbWFya2VyJ3MgaW5mb3JtYXRpb25cbiAgICAgICAgaWYgKG9wdGlvbnMucG9wdXApIHtcbiAgICAgICAgICAgIHZhciBwb3B1cCA9ICc8YnV0dG9uIGNsYXNzPVwibWFwLXBvcHVwLWxpbmtcIiBvbmNsaWNrPVwid2luZG93LmxvY2F0aW9uLmhyZWY9XFwnJyArIGl0ZW0udXJsICsgJ1xcJ1wiPicgKyBpdGVtLmRpc3BsYXlfbmFtZSArICcgJyArIGl0ZW0ubmF0dXJhbF9wb3N0X3R5cGUgKyAnIDxiPicgKyBpdGVtLnRpdGxlICsgJzwvYj48L2J1dHRvbj48cD48ZW0+JyArIGl0ZW0uZXhjaGFuZ2VUeXBlcyArICc8L2VtPjwvcD4nXG4gICAgICAgICAgICBtYXJrZXIuYmluZFBvcHVwKHBvcHVwKVxuXG4gICAgICAgICAgICB2YXIgcG9wdXAgPSBMLkRvbVV0aWwuY3JlYXRlKCdkaXYnLCAnbWFwLXBvcHVwJylcbiAgICAgICAgICAgIHBvcHVwLmlubmVySFRNTCA9ICc8ZGl2PicgKyBpdGVtLmltYWdlICsgJzwvZGl2PjxhIGhyZWY9XCInICsgaXRlbS51cmwgKyAnXCIgY2xhc3M9XCJtYXAtcG9wdXAtbGlua1wiPicgKyBpdGVtLmRpc3BsYXlfbmFtZSArICcgJyArIGl0ZW0ubmF0dXJhbF9wb3N0X3R5cGUgKyAnIDxiPicgKyBpdGVtLnRpdGxlICsgJzwvYj48L2E+PHA+PGVtPicgKyBpdGVtLmV4Y2hhbmdlVHlwZXMgKyAnPC9lbT48L3A+J1xuXG4gICAgICAgICAgICBtYXJrZXIuYmluZFBvcHVwKHBvcHVwKVxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5tYXJrZXJzLnB1c2gobWFya2VyKVxuICAgICAgICBtYXJrZXIuYWRkVG8odGhpcy5pbnN0YW5jZSlcblxuICAgICAgICByZXR1cm4gbWFya2VyXG4gICAgfVxuXG4gICAgZ29Ub0xpbmtMaXN0ZW5lciAobGluaykge1xuICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IGxpbmtcbiAgICB9XG5cbiAgICByZW1vdmVNYXJrZXJzICgpIHtcbiAgICAgICAgdGhpcy5tYXJrZXJzLmZvckVhY2goKG0pID0+IHtcbiAgICAgICAgICAgIG0ucmVtb3ZlKClcbiAgICAgICAgfSlcblxuICAgICAgICB0aGlzLm1hcmtlcnMgPSBbXVxuICAgIH1cblxuICAgIGNlbnRlciAoKSB7XG4gICAgICAgIGlmICh0aGlzLmxhdCAmJiB0aGlzLmxuZykge1xuICAgICAgICAgICAgdGhpcy5pbnN0YW5jZS5zZXRWaWV3KG5ldyBMLkxhdExuZyh0aGlzLmxhdCwgdGhpcy5sbmcpLCAxOClcbiAgICAgICAgICAgIHJldHVybiB0aGlzXG4gICAgICAgIH1cblxuICAgICAgICB2YXIgcG9pbnRzID0gW11cblxuICAgICAgICB0aGlzLm1hcmtlcnMuZm9yRWFjaCgobWspID0+IHtcbiAgICAgICAgICAgIHBvaW50cy5wdXNoKFttay5nZXRMYXRMbmcoKS5sYXQsIG1rLmdldExhdExuZygpLmxuZ10pXG4gICAgICAgIH0pXG5cbiAgICAgICAgaWYgKHBvaW50cy5sZW5ndGggPT09IDApIHtcbiAgICAgICAgICAgIHJldHVybiB0aGlzXG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmluc3RhbmNlLmZpdEJvdW5kcyhwb2ludHMpXG4gICAgICAgIHJldHVybiB0aGlzXG4gICAgfVxufVxuXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cblxud2luZG93LmNyZWF0ZU1hcFJlbmRlcmVyID0gZnVuY3Rpb24gKHNlbGVjdG9yKSB7XG4gICAgcmV0dXJuIG5ldyBNYXBSZW5kZXJlcihzZWxlY3Rvcilcbn1cblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2pzL21hcHMuanMiXSwibWFwcGluZ3MiOiJBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBSUE7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ }
/******/ ]);