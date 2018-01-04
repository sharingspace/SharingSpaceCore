<div id="map-area" style="position: relative; margin-top: 4px; margin-bottom: 4px;">
    <div id="entry_browse_map_widget" class="wrld-widget-container"></div>
    @if (config('services.mapbox.access_token') || ($whitelabel_group->wrld3d && $whitelabel_group->wrld3d->get('api_key')))
        <div id="entry_browse_map" style="height: {{ isset($size) ? $size : '460' }}px;"></div>
    @else
        <div id="entry_browse_map" style="height: 0px; display: none;"></div>
    @endif
</div>