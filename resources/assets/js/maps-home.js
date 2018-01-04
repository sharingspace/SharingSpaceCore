import { MapRenderer3d } from './maps3d'
import { MapRenderer2d } from './maps2d'

/**
 * Initialize the entry map in the frontend site.
 *
 * @param entry
 * @param community
 */
window.initializeHomeMap = function (community, options) {
    if (!community || !community.lat || !community.lng) {
        return
    }

    /*
     * Instantiate the map renderer
     */
    const mapOptions = {
        loadPois: true,
        lat: parseFloat(community.lat),
        lng: parseFloat(community.lng),
    }

    const map = (community.wrld3d && community.wrld3d.api_key)
        ? new MapRenderer3d('entry_browse_map', mapOptions)
        : new MapRenderer2d('entry_browse_map', mapOptions)

    return Promise.resolve(map)
}