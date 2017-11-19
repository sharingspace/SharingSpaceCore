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

eval("var MapRenderer = function MapRenderer (selector) {\n    this.selector = selector\n    this.wrld3dApiKey = window.WRLD_3D_API_KEY\n    this.mapboxKey = window.MAPBOX_KEY\n\n    this.markers = []\n    this.instance = null\n    this.lat = null\n    this.lng = null\n\n    this.createInstance()\n};\n\nMapRenderer.prototype.createInstance = function createInstance () {\n    if (this.wrld3dApiKey) {\n        this.instance = L.Wrld.map(this.selector, this.wrld3dApiKey)\n        return this\n    }\n\n    this.instance = L.map(this.selector)\n\n    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + this.mapboxKey, {\n        attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',\n        maxZoom: 18,\n        id: 'mapbox.streets',\n        accessToken: this.mapboxKey\n    }).addTo(this.instance)\n\n    return this\n};\n\nMapRenderer.prototype.setLatLng = function setLatLng (lat, lng) {\n    this.lat = parseFloat(lat)\n    this.lng = parseFloat(lng)\n\n    return this\n};\n\nMapRenderer.prototype.loadMarkers = function loadMarkers (markers, options) {\n        var this$1 = this;\n\n    options = Object.assign({}, {\n        merge: false,\n        popup: true,\n        tooltip: true,\n    }, options)\n\n    if (!options.merge) {\n        this.removeMarkers()\n    }\n\n    markers.forEach(function (m) {\n        this$1.addMapMarker(m, options)\n    })\n\n    return this\n};\n\nMapRenderer.prototype.addMapMarker = function addMapMarker (item, options) {\n    if (!item.latitude || !item.longitude) {\n        return\n    }\n\n    var marker = L.marker([item.latitude, item.longitude])\n\n    if (options.tooltip) {\n        marker.bindTooltip(item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })\n    }\n\n    if (options.popup) {\n        var popup = '<button class=\"map-popup-link\" onclick=\"window.location.href=\\'' + item.url + '\\'\">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></button><p><em>' + item.exchangeTypes + '</em></p>'\n        marker.bindPopup(popup)\n    }\n\n    this.markers.push(marker)\n    marker.addTo(this.instance)\n\n    return marker\n};\n\nMapRenderer.prototype.removeMarkers = function removeMarkers () {\n    this.markers.forEach(function (m) {\n        m.remove()\n    })\n\n    this.markers = []\n};\n\nMapRenderer.prototype.center = function center () {\n    var ZOOM = 21\n\n    // center the map based on Sharing Network geolocation positions\n    if (this.latitude && this.longitude) {\n        this.instance.setView(new L.LatLng(this.latitude, this.longitude), ZOOM)\n        return this\n    }\n\n    // When Sharing Network geolocation is not provided, we define\n    // the center of view based on the location of all points.\n    var points = []\n\n    this.markers.forEach(function (mk) {\n        points.push([mk.getLatLng().lat, mk.getLatLng().lng])\n    })\n\n    if (points.length > 0) {\n        this.instance.fitBounds(points)\n        // this.instance.setZoom(ZOOM)\n    }\n};\n\n// ---------------------------------------------------------\n\nwindow.createMapRenderer = function (selector) {\n    return new MapRenderer(selector)\n}//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL21hcHMuanM/ODE1MCJdLCJzb3VyY2VzQ29udGVudCI6WyJjbGFzcyBNYXBSZW5kZXJlciB7XG4gICAgY29uc3RydWN0b3IgKHNlbGVjdG9yKSB7XG4gICAgICAgIHRoaXMuc2VsZWN0b3IgPSBzZWxlY3RvclxuICAgICAgICB0aGlzLndybGQzZEFwaUtleSA9IHdpbmRvdy5XUkxEXzNEX0FQSV9LRVlcbiAgICAgICAgdGhpcy5tYXBib3hLZXkgPSB3aW5kb3cuTUFQQk9YX0tFWVxuXG4gICAgICAgIHRoaXMubWFya2VycyA9IFtdXG4gICAgICAgIHRoaXMuaW5zdGFuY2UgPSBudWxsXG4gICAgICAgIHRoaXMubGF0ID0gbnVsbFxuICAgICAgICB0aGlzLmxuZyA9IG51bGxcblxuICAgICAgICB0aGlzLmNyZWF0ZUluc3RhbmNlKClcbiAgICB9XG5cbiAgICBjcmVhdGVJbnN0YW5jZSAoKSB7XG4gICAgICAgIGlmICh0aGlzLndybGQzZEFwaUtleSkge1xuICAgICAgICAgICAgdGhpcy5pbnN0YW5jZSA9IEwuV3JsZC5tYXAodGhpcy5zZWxlY3RvciwgdGhpcy53cmxkM2RBcGlLZXkpXG4gICAgICAgICAgICByZXR1cm4gdGhpc1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5pbnN0YW5jZSA9IEwubWFwKHRoaXMuc2VsZWN0b3IpXG5cbiAgICAgICAgTC50aWxlTGF5ZXIoJ2h0dHBzOi8vYXBpLnRpbGVzLm1hcGJveC5jb20vdjQve2lkfS97en0ve3h9L3t5fS5wbmc/YWNjZXNzX3Rva2VuPScgKyB0aGlzLm1hcGJveEtleSwge1xuICAgICAgICAgICAgYXR0cmlidXRpb246ICdNYXAgZGF0YSAmY29weTsgPGEgaHJlZj1cImh0dHA6Ly9vcGVuc3RyZWV0bWFwLm9yZ1wiPk9wZW5TdHJlZXRNYXA8L2E+IGNvbnRyaWJ1dG9ycywgPGEgaHJlZj1cImh0dHA6Ly9jcmVhdGl2ZWNvbW1vbnMub3JnL2xpY2Vuc2VzL2J5LXNhLzIuMC9cIj5DQy1CWS1TQTwvYT4sIEltYWdlcnkgwqkgPGEgaHJlZj1cImh0dHA6Ly9tYXBib3guY29tXCI+TWFwYm94PC9hPicsXG4gICAgICAgICAgICBtYXhab29tOiAxOCxcbiAgICAgICAgICAgIGlkOiAnbWFwYm94LnN0cmVldHMnLFxuICAgICAgICAgICAgYWNjZXNzVG9rZW46IHRoaXMubWFwYm94S2V5XG4gICAgICAgIH0pLmFkZFRvKHRoaXMuaW5zdGFuY2UpXG5cbiAgICAgICAgcmV0dXJuIHRoaXNcbiAgICB9XG5cbiAgICBzZXRMYXRMbmcgKGxhdCwgbG5nKSB7XG4gICAgICAgIHRoaXMubGF0ID0gcGFyc2VGbG9hdChsYXQpXG4gICAgICAgIHRoaXMubG5nID0gcGFyc2VGbG9hdChsbmcpXG5cbiAgICAgICAgcmV0dXJuIHRoaXNcbiAgICB9XG5cbiAgICBsb2FkTWFya2VycyAobWFya2Vycywgb3B0aW9ucykge1xuICAgICAgICBvcHRpb25zID0gT2JqZWN0LmFzc2lnbih7fSwge1xuICAgICAgICAgICAgbWVyZ2U6IGZhbHNlLFxuICAgICAgICAgICAgcG9wdXA6IHRydWUsXG4gICAgICAgICAgICB0b29sdGlwOiB0cnVlLFxuICAgICAgICB9LCBvcHRpb25zKVxuXG4gICAgICAgIGlmICghb3B0aW9ucy5tZXJnZSkge1xuICAgICAgICAgICAgdGhpcy5yZW1vdmVNYXJrZXJzKClcbiAgICAgICAgfVxuXG4gICAgICAgIG1hcmtlcnMuZm9yRWFjaCgobSkgPT4ge1xuICAgICAgICAgICAgdGhpcy5hZGRNYXBNYXJrZXIobSwgb3B0aW9ucylcbiAgICAgICAgfSlcblxuICAgICAgICByZXR1cm4gdGhpc1xuICAgIH1cblxuICAgIGFkZE1hcE1hcmtlciAoaXRlbSwgb3B0aW9ucykge1xuICAgICAgICBpZiAoIWl0ZW0ubGF0aXR1ZGUgfHwgIWl0ZW0ubG9uZ2l0dWRlKSB7XG4gICAgICAgICAgICByZXR1cm5cbiAgICAgICAgfVxuXG4gICAgICAgIHZhciBtYXJrZXIgPSBMLm1hcmtlcihbaXRlbS5sYXRpdHVkZSwgaXRlbS5sb25naXR1ZGVdKVxuXG4gICAgICAgIGlmIChvcHRpb25zLnRvb2x0aXApIHtcbiAgICAgICAgICAgIG1hcmtlci5iaW5kVG9vbHRpcChpdGVtLmRpc3BsYXlfbmFtZSArICcgJyArIGl0ZW0ubmF0dXJhbF9wb3N0X3R5cGUgKyAnIDxiPicgKyBpdGVtLnRpdGxlICsgJzwvYj4nLCB7IHBlcm1hbmVudDogZmFsc2UgfSlcbiAgICAgICAgfVxuXG4gICAgICAgIGlmIChvcHRpb25zLnBvcHVwKSB7XG4gICAgICAgICAgICB2YXIgcG9wdXAgPSAnPGJ1dHRvbiBjbGFzcz1cIm1hcC1wb3B1cC1saW5rXCIgb25jbGljaz1cIndpbmRvdy5sb2NhdGlvbi5ocmVmPVxcJycgKyBpdGVtLnVybCArICdcXCdcIj4nICsgaXRlbS5kaXNwbGF5X25hbWUgKyAnICcgKyBpdGVtLm5hdHVyYWxfcG9zdF90eXBlICsgJyA8Yj4nICsgaXRlbS50aXRsZSArICc8L2I+PC9idXR0b24+PHA+PGVtPicgKyBpdGVtLmV4Y2hhbmdlVHlwZXMgKyAnPC9lbT48L3A+J1xuICAgICAgICAgICAgbWFya2VyLmJpbmRQb3B1cChwb3B1cClcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMubWFya2Vycy5wdXNoKG1hcmtlcilcbiAgICAgICAgbWFya2VyLmFkZFRvKHRoaXMuaW5zdGFuY2UpXG5cbiAgICAgICAgcmV0dXJuIG1hcmtlclxuICAgIH1cblxuICAgIHJlbW92ZU1hcmtlcnMgKCkge1xuICAgICAgICB0aGlzLm1hcmtlcnMuZm9yRWFjaCgobSkgPT4ge1xuICAgICAgICAgICAgbS5yZW1vdmUoKVxuICAgICAgICB9KVxuXG4gICAgICAgIHRoaXMubWFya2VycyA9IFtdXG4gICAgfVxuXG4gICAgY2VudGVyICgpIHtcbiAgICAgICAgY29uc3QgWk9PTSA9IDIxXG5cbiAgICAgICAgLy8gY2VudGVyIHRoZSBtYXAgYmFzZWQgb24gU2hhcmluZyBOZXR3b3JrIGdlb2xvY2F0aW9uIHBvc2l0aW9uc1xuICAgICAgICBpZiAodGhpcy5sYXRpdHVkZSAmJiB0aGlzLmxvbmdpdHVkZSkge1xuICAgICAgICAgICAgdGhpcy5pbnN0YW5jZS5zZXRWaWV3KG5ldyBMLkxhdExuZyh0aGlzLmxhdGl0dWRlLCB0aGlzLmxvbmdpdHVkZSksIFpPT00pXG4gICAgICAgICAgICByZXR1cm4gdGhpc1xuICAgICAgICB9XG5cbiAgICAgICAgLy8gV2hlbiBTaGFyaW5nIE5ldHdvcmsgZ2VvbG9jYXRpb24gaXMgbm90IHByb3ZpZGVkLCB3ZSBkZWZpbmVcbiAgICAgICAgLy8gdGhlIGNlbnRlciBvZiB2aWV3IGJhc2VkIG9uIHRoZSBsb2NhdGlvbiBvZiBhbGwgcG9pbnRzLlxuICAgICAgICB2YXIgcG9pbnRzID0gW11cblxuICAgICAgICB0aGlzLm1hcmtlcnMuZm9yRWFjaCgobWspID0+IHtcbiAgICAgICAgICAgIHBvaW50cy5wdXNoKFttay5nZXRMYXRMbmcoKS5sYXQsIG1rLmdldExhdExuZygpLmxuZ10pXG4gICAgICAgIH0pXG5cbiAgICAgICAgaWYgKHBvaW50cy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICB0aGlzLmluc3RhbmNlLmZpdEJvdW5kcyhwb2ludHMpXG4gICAgICAgICAgICAvLyB0aGlzLmluc3RhbmNlLnNldFpvb20oWk9PTSlcbiAgICAgICAgfVxuICAgIH1cbn1cblxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXG5cbndpbmRvdy5jcmVhdGVNYXBSZW5kZXJlciA9IGZ1bmN0aW9uIChzZWxlY3Rvcikge1xuICAgIHJldHVybiBuZXcgTWFwUmVuZGVyZXIoc2VsZWN0b3IpXG59XG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHJlc291cmNlcy9hc3NldHMvanMvbWFwcy5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUlBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9");

/***/ }
/******/ ]);