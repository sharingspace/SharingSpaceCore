import { MapRenderer3d } from './maps3d'
import { MapRenderer2d } from './maps2d'

/**
 * Prepare an indoors object.
 *
 * @param entry
 * @returns {{id: null, floor: null}}
 */
function prepareEntryIndoors (entry) {
    if (!entry.indoors) {
        return {
            id: null,
            floor: null,
        }
    }

    return indoors = {
        id: entry.indoors.id || null,
        floor: entry.indoors.floor || null,
    }
}

/**
 * Handle the map viewing.
 *
 * @param map
 * @param entry
 */
function handleViewing (map, entry) {
    if (!entry.lat || !entry.lon) {
        return
    }

    if (map.type === '3d' && entry.indoor) {
        map.instance.indoors.on('indoorentranceadd', function () {
            map.centerAt(entry)
            map.enterBuilding(entry.indoor_id, entry.floor_id)
        })

        map.instance.indoors.on('indoormapenter', function () {
            map.addMapMarker(entry, { popup: false, tooltip: false })
        })

        return
    }

    map.centerAt(entry)
    map.addMapMarker(entry, { popup: false, tooltip: false })
}

/**
 * Handle the marker editing feature.
 *
 * @param map
 * @param entry
 */
function handleEditing (map, entry) {
    /*
     * When the user does a double click on the map,
     *we update the entry's geolocation.
     */
    map.instance.on('dblclick', (ev) => {
        map.instance.fire('locationUpdated', ev.latlng)
    })

    /*
     * The event that updates the entry's marker.
     */
    map.instance.on('locationUpdated', (ev) => {
        entry.lat = ev.lat
        entry.lng = ev.lng
        entry.lon = ev.lng

        printAddress(entry.lat, entry.lon)

        /*
         * Set some required data for the entry.
         */
        $('#location_lat').val(entry.lat)
        $('#location_lng').val(entry.lon)

        /*
         * Set up some indoor map stuff if the map is a 3D one.
         */
        if (map.type === '3d') {
            var indoor = map.instance.indoors.getActiveIndoorMap()
            var floor = map.instance.indoors.getFloor()

            /*
             * We can have a lot of entries already added before
             * the Map stuff is added, so we have to ensure that
             * the entry has the need indoors data.
             */
            prepareEntryIndoors(entry)

            entry.indoor = indoor
            entry.indoor_id = indoor === null ? '' : indoor.getIndoorMapId()
            entry.floor_id = indoor === null ? '' : floor.getFloorIndex()

            $('#indoors_id').val(entry.indoor_id)
            $('#indoors_floor').val(entry.floor_id)
        }

        /*
         * Clean up the existent marker and add up the new one.
         */
        map.removeMarkers()

        map.addMapMarker(entry, { popup: false, tooltip: false }).centerAt(entry)
    })
}

/**
 * Initialize the entry map in the frontend site.
 *
 * @param entry
 * @param community
 */
window.initializeEntryMap = function (entry, community, options) {
    if (!community) {
        return
    }

    /*
     * Instantiate the map renderer
     */
    const mapOptions = {
        loadPois: false,
        lat: parseFloat(community.lat),
        lng: parseFloat(community.lng),
    }

    const map = (community.wrld3d && community.wrld3d.api_key)
        ? new MapRenderer3d('entry_browse_map', mapOptions)
        : new MapRenderer2d('entry_browse_map', mapOptions)

    /*
     * Set some required data for the entry.
     */
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

    handleViewing(map, entry)

    /*
     * Enables the market editing when it's requested.
     */
    if (options.editable) {
        handleEditing(map, entry)
    }

    window.map = map
}