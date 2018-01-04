@if ($whitelabel_group->latitude && $whitelabel_group->longitude)
    <div id="map-area" style="position: relative; margin-top: 4px; margin-bottom: 4px;">
        <div id="entry_browse_map_widget" class="wrld-widget-container"></div>
        <div id="entry_browse_map" style="height: {{ isset($size) ? $size : '460' }}px;"></div>
    </div>
@endif