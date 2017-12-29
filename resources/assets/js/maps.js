class MapRenderer {
    constructor (selector, options) {
        this.selector = selector
        this.wrld3dApiKey = window.WRLD_3D_API_KEY
        this.mapboxKey = window.MAPBOX_KEY
        this.markers = []
        this.instance = null
        this.indoorControl = null
        this.poiApi = null
        this.markerController = null
        this.lat = null
        this.lng = null

        this.createInstance(options)
    }

    createInstance (options) {
        Object.assign(options, {}, options)

        if (this.wrld3dApiKey) {
            this.instance = L.Wrld.map(this.selector, this.wrld3dApiKey, {
                indoorsEnabled: true,
            })

            this.indoorControl = new WrldIndoorControl(this.selector + '_widget', this.instance)
            this.markerController = new WrldMarkerController(this.instance)

            this.poiApi = new WrldPoiApi(this.wrld3dApiKey)

            return this
        }

        this.instance = L.map(this.selector)

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + this.mapboxKey, {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: this.mapboxKey
        }).addTo(this.instance)

        return this
    }

    setLatLng (lat, lng) {
        this.lat = parseFloat(lat)
        this.lng = parseFloat(lng)

        return this
    }

    loadMarkers (markers, options) {
        options = Object.assign({}, {
            merge: false,
            popup: true,
            tooltip: true,
        }, options)

        if (!options.merge) {
            this.removeMarkers()
        }

        this.poiApi.searchTags(['anyshare_entries'], this.instance.getCenter(), (success, results) => {
            if (!success || results.length === 0) {
                return
            }

            results.forEach((item) => {
                this.addMapMarker(item, options)
            })
        }, { radius: 5000, number: 500 })

        return this
    }

    /**
     * Item properties:
     *  - id
     *  - indoor_id
     *  - floor_id
     *  - lat
     *  - lon
     *  - title
     *  - subtitle
     *  - user_data
     *    - natural_post_type
     *    - image_url
     *    - author_name
     *    - url
     *    - exchange_types
     *
     * @param item
     * @param options
     */
    addMapMarker (item, options) {
        var markerOpts = {
            iconKey: 'pin',
        }

        if (item.indoor) {
            markerOpts.isIndoor = true
            markerOpts.indoorId = item.indoor_id
            markerOpts.floorIndex = parseInt(item.floor_id)
        }

        const id = item.id || (+new Date * Math.random() + 1).toString(36).substring(2, 10)

        var marker = this.markerController.addMarker(id, [item.lat, item.lon], markerOpts)

        // Add a tooltip to the marker
        if (options.tooltip) {
            marker.bindTooltip(item.user_data.author_name + ' ' + item.user_data.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })
        }

        // Add a popup with marker's information
        if (options.popup) {
            var popup = '<button class="map-popup-link" onclick="window.location.href=\'' + item.user_data.url + '\'">' + item.user_data.author_name + ' ' + item.user_data.natural_post_type + ' <b>' + item.title + '</b></button><p><em>' + item.user_data.exchange_types + '</em></p>'
            marker.bindPopup(popup)

            var popup = L.DomUtil.create('div', 'map-popup')
            popup.innerHTML = '<div>' + (item.user_data.hasOwnProperty('image_url') ? item.user_data.image_url : '') + '</div><a href="' + item.user_data.url + '" class="map-popup-link">' + item.user_data.author_name + ' ' + item.user_data.natural_post_type + ' <b>' + item.title + '</b></a><p><em>' + item.user_data.exchange_types + '</em></p>'

            marker.bindPopup(popup)
        }

        this.markers.push(marker)
        return this
    }

    removeMarkers () {
        this.markers.forEach((m) => {
            this.markerController.removeMarker(m.id)
        })

        this.markers = []
    }

    precache (location) {
        this.instance.precache(location, 1000, () => {
            console.log('Wrld3D caching OK.')
        })
    }

    centerAt (entry) {
        this.instance.setView([entry.lat, entry.lon], 14)
        this.precache([entry.lat, entry.lon])
    }

    enterBuilding (indoorId, floor) {
        if (!indoorId) {
            return
        }

        this.instance.indoors.enter(indoorId)
        this.instance.indoors.setFloor(floor)
    }

    center () {
        if (this.lat && this.lng) {
            this.instance.setView([this.lat, this.lng], 18)
            return this
        }

        var points = []

        this.markers.forEach((mk) => {
            points.push([mk.getLatLng().lat, mk.getLatLng().lng])
        })

        if (points.length === 0) {
            return this
        }

        this.instance.fitBounds(points)
        this.precache(this.instance.getCenter())
        return this
    }
}

// ---------------------------------------------------------

window.createMapRenderer = function (selector, options) {
    return Promise.resolve(new MapRenderer(selector, options || {}))
}
