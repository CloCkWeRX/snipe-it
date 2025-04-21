@if (config('services.google.maps_api_key'))
    @if (($item->present()->coordinates!=''))
        <div class="col-md-12 text-center" style="padding-bottom: 20px;">
            <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($item->present()->coordinates) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
        </div>
    @elseif (($item->item!='') && ($item->state!='') && ($item->country!=''))
        <div class="col-md-12 text-center" style="padding-bottom: 20px;">
            <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($item->address.','.$item->city.' '.$item->state.' '.$item->country.' '.$item->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
        </div>
    @endif
@elseif (($item->present()->coordinates!=''))
    <style>#map { height: 300px !important }/** @todo https://github.com/ginocampra/laravel-leaflet/issues/13 */</style>
    <div>
        <x-laravel-map :initialMarkers="$initialMarkers" :options="$options"/>
    </div>
@endif
