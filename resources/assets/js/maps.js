class MapRenderer {
    constructor (selector) {
        this.selector = selector
        this.wrld3dApiKey = window.WRLD_3D_API_KEY
        this.mapboxKey = window.MAPBOX_KEY
        this.markers = []
        this.instance = null
        this.lat = null
        this.lng = null

        this.createInstance()
    }

    createInstance () {
        if (this.wrld3dApiKey) {
            this.instance = L.Wrld.map(this.selector, this.wrld3dApiKey, {
                indoorsEnabled: true,
            })

            this.listenFloorControls()
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

    listenFloorControls () {
        $('.map-area__topFloor').on('click', () => {
            const indoorMap = this.instance.indoors.getActiveIndoorMap()
            if (indoorMap) {
                this.instance.indoors.setFloor(indoorMap.getFloorCount() - 1)
            }
        })

        $('.map-area__moveUp').on('click', () => {
            this.instance.indoors.moveUp()
        })

        $('.map-area__moveDown').on('click', () => {
            this.instance.indoors.moveDown()
        })

        $('.map-area__bottomFloor').on('click', () => {
            this.instance.indoors.setFloor(0)
        })

        $('.map-area__exitIndoors').on('click', () => {
            this.instance.indoors.exit()
        })
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

        markers.forEach((m) => {
            this.addMapMarker(m, options)
        })

        return this
    }

    addMapMarker (item, options) {

        if (!$.isNumeric(item.latitude) || !$.isNumeric(item.longitude)) {
            return
        }

        var marker = L.marker([item.latitude, item.longitude])

        // Add a tooltip to the marker
        if (options.tooltip) {
            marker.bindTooltip(item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b>', { permanent: false })
        }

        // Add a popup with marker's information
        if (options.popup) {
            var popup = '<button class="map-popup-link" onclick="window.location.href=\'' + item.url + '\'">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></button><p><em>' + item.exchangeTypes + '</em></p>'
            marker.bindPopup(popup)

            var popup = L.DomUtil.create('div', 'map-popup')
            popup.innerHTML = '<div>' + item.image + '</div><a href="' + item.url + '" class="map-popup-link">' + item.display_name + ' ' + item.natural_post_type + ' <b>' + item.title + '</b></a><p><em>' + item.exchangeTypes + '</em></p>'

            marker.bindPopup(popup)
        }

        this.markers.push(marker)
        marker.addTo(this.instance)

        return marker
    }

    goToLinkListener (link) {
        window.location.href = link
    }

    removeMarkers () {
        this.markers.forEach((m) => {
            m.remove()
        })

        this.markers = []
    }

    center () {
        if (this.lat && this.lng) {
            this.instance.setView(new L.LatLng(this.lat, this.lng), 18)
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
        return this
    }
}

// ---------------------------------------------------------

window.createMapRenderer = function (selector) {
    return new MapRenderer(selector)
}
