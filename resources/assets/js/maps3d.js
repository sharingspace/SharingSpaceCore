export class MapRenderer3d {
    constructor (selector, options) {
        console.log('map-renderer-3d')

        this.instance = null
        this.type = '3d'
        this.selector = selector
        this.wrld3dApiKey = window.WRLD_3D_API_KEY
        this.mapboxKey = window.MAPBOX_KEY
        this.markers = []
        this.markerController = null
        this.pois = []
        this.poiController = null
        this.lat = options.lat || null
        this.lng = options.lng || null

        if (this.wrld3dApiKey) {
            this.createInstance(options)
        }
    }

    /**
     * Initialize a new instance of the map, be it a default Leaflet map
     * or a Wrld3D one.
     *
     * @param options
     * @returns {MapRenderer}
     */
    createInstance (options) {
        Object.assign(options, {}, options)

        this.instance = L.Wrld.map(this.selector, this.wrld3dApiKey, {
            indoorsEnabled: true,
        })

        // Add the indoor control widget. It's used to navigate in the
        // indoor buildings provided by WRLD 3D maps.
        new WrldIndoorControl(this.selector + '_widget', this.instance)

        // Add the marker and POI controllers. They are used to show every
        // Entry marker and Point of Interest on the WRLD 3D map.
        this.markerController = new WrldMarkerController(this.instance)
        this.poiController = new WrldMarkerController(this.instance)

        this.center()
        return this
    }

    /**
     * Set latitude and longitude of the map.
     *
     * @param lat
     * @param lng
     * @returns {MapRenderer3d}
     */
    setLatLng (lat, lng) {
        this.lat = parseFloat(lat)
        this.lng = parseFloat(lng)

        return this
    }

    /**
     * Load an array of POIs into the 3d map.
     *
     * @param pois
     * @param options
     */
    loadPois (pois, options) {
        options = Object.assign({}, {
            merge: false,
            popup: true,
            tooltip: true,
        }, options)

        if (!options.merge) {
            this.removePois()
        }

        pois.forEach((poi) => {
            if (poi) {
                this.addMapPoi(poi, options)
            }
        })

        return this
    }

    /**
     * Load an array of entry markers into the 3d map.
     *
     * @param markers
     * @param options
     * @returns {MapRenderer3d}
     */
    loadMarkers (markers, options) {
        options = Object.assign({}, {
            merge: false,
            popup: true,
            tooltip: true,
        }, options)

        if (!options.merge) {
            this.removeMarkers()
        }

        markers.forEach((mk) => {
            if (mk.poi) {
                this.addMapMarker(mk.poi, options)
            }
        })

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
        const marker = this.markerController.addMarker(id, [item.lat, item.lon], markerOpts)

        // Add a tooltip to the marker
        if (options.tooltip) {
            marker.bindTooltip(item.user_data.author_name + ' ' + item.user_data.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })
        }

        // Add a popup with marker's information
        if (options.popup) {
            const popup = L.DomUtil.create('div', 'map-popup')

            const image = (item.user_data.hasOwnProperty('image_url') && item.user_data.image_url)
                ? `<a href="${item.user_data.url}"><img src="${item.user_data.image_url}" class="entry_image"></a>`
                : ''

            popup.innerHTML = '<div>' + image + '</div><a href="' + item.user_data.url + '" class="map-popup-link">' + item.user_data.author_name + ' ' + item.user_data.natural_post_type + ' <b>' + item.title + '</b></a><p><em>' + item.user_data.exchange_types + '</em></p>'

            marker.bindPopup(popup)
        }

        this.markers.push(marker)
        return this
    }

    /**
     * Add a Point of Interest pin to the map.
     *
     * @param item
     * @param options
     * @returns {MapRenderer3d}
     */
    addMapPoi (item, options) {
        var poiOpts = {
            iconKey: item.icon || 'aroundme',
        }

        if (item.indoor) {
            poiOpts.isIndoor = true
            poiOpts.indoorId = item.indoor_id
            poiOpts.floorIndex = parseInt(item.floor_id)
        }

        const id = item.id || (+new Date * Math.random() + 1).toString(36).substring(2, 10)
        const poi = this.poiController.addMarker(id, [item.lat, item.lon], poiOpts)

        // Add a tooltip to the marker
        if (options.tooltip) {
            poi.bindTooltip(item.title, { permanent: false })
        }

        // Add a popup with marker's information
        if (options.popup) {
            const popup = L.DomUtil.create('div', 'map-popup')

            const image = (item.user_data.hasOwnProperty('image_url') && item.user_data.image_url)
                ? `<a href="${item.user_data.url}"><img src="${item.user_data.image_url}" class="entry_image"></a>`
                : ''

            popup.innerHTML = `
                <div>${image}</div>
                <a href="${item.user_data.url || item.user_data.custom_view}" class="map-popup-link">${item.title}</a>
                <p><em>${item.subtitle || ''}</em></p>
                <p>${item.user_data.description || ''}</p>
            `

            poi.bindPopup(popup)
        }

        this.pois.push(poi)
        return this
    }

    /**
     * Remove all POIs.
     */
    removePois () {
        this.pois.forEach((p) => {
            this.poiController.removeMarker(p.id)
        })

        this.pois = []
    }

    /**
     * Remove all markers.
     */
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
        this.instance.setView([entry.lat, entry.lon], 18)
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