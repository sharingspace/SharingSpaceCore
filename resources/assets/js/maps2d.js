export class MapRenderer2d {
    constructor (selector, options) {
        this.type = '2d'
        this.selector = selector
        this.mapboxKey = window.MAPBOX_KEY
        this.markers = []
        this.instance = null
        this.lat = options.lat || null
        this.lng = options.lng || null

        console.log('map-renderer-2d')

        if (this.mapboxKey) {
            this.createInstance(options)
        }
    }

    /**
     * Initialize a new instance of the default Leaflet map.
     *
     * @param options
     * @returns {MapRenderer}
     */
    createInstance (options) {
        Object.assign(options, {}, options)

        this.instance = L.map(this.selector)

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + this.mapboxKey, {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: this.mapboxKey
        }).addTo(this.instance)

        
        this.center()

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

        markers.forEach((item) => {
            this.addMapMarker(item, options)
        })

        return this
    }

    loadPois (pois, options) {
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
        item = this.prepareEntry(item)

        if (!$.isNumeric(item.lat) || !$.isNumeric(item.lon)) {
            return
        }

        var marker = L.marker([item.lat, item.lon])

        // Add a tooltip to the marker
        if (options.tooltip) {
            marker.bindTooltip(item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })
        }

        // Add a popup with marker's information
        if (options.popup) {
            var popup = L.DomUtil.create('div', 'map-popup')
            popup.innerHTML = '<div>' + item.image + '</div><a href="' + item.url + '" class="map-popup-link">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></a><p><em>' + item.exchangeTypes + '</em></p>'

            marker.bindPopup(popup)
        }

        this.markers.push(marker)
        marker.addTo(this.instance)

        return this
    }

    removeMarkers () {
        this.markers.forEach((m) => {
            m.remove()
        })

        this.markers = []
    }

    centerAt (entry) {
        if (entry.lat && entry.lon) {
            this.instance.setView([entry.lat, entry.lon], 14)
        }

        return this
    }

    center () {
        var points = []

        if (this.lat && this.lng) {
            points.push([this.lat, this.lng])
        }

        this.markers.forEach((mk) => {
            points.push(mk.getLatLng())
        })

        if (points.length === 0) {
            return this
        }

        this.instance.fitBounds(new L.LatLngBounds(points))

        return this
    }

    prepareEntry (entry) {
        entry.lon = entry.lng
        entry.indoor = (entry.wrld3d && entry.wrld3d.indoor_id)
        entry.indoor_id = entry.wrld3d ? entry.wrld3d.indoor_id : null
        entry.floor_id = entry.wrld3d ? entry.wrld3d.indoor_floor : null

        entry.user_data = {
            description: entry.description,
            image_url: entry.image_url,
            author_name: entry.display_name,
            natural_post_type: entry.natural_post_type,
            exchanges_types: entry.exchangesTypes,
            url: entry.url,
        }

        return entry
    }
}