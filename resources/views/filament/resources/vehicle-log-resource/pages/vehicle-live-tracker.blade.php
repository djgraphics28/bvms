<x-filament-panels::page>
  <div class="w-full h-[500px]" id="map"></div>

  <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapApiKey }}"></script>

  <script>
    let map;
    let marker;

    function initMap() {
      const initialPosition = { lat: {{ $lat }}, lng: {{ $lng }} };

      map = new google.maps.Map(document.getElementById("map"), {
        center: initialPosition,
        zoom: 15,
      });

      marker = new google.maps.Marker({
        position: initialPosition,
        map: map,
        title: "Vehicle Location",
      });
    }

    function updateMap(lat, lng) {
      const newLatLng = new google.maps.LatLng(lat, lng);
      marker.setPosition(newLatLng);
      map.panTo(newLatLng);
    }

    document.addEventListener("livewire:load", () => {
      initMap();

      Livewire.hook('element.updated', () => {
        const lat = @json($vehicle->device->latitude ?? 0);
        const lng = @json($vehicle->device->longitude ?? 0);
        updateMap(lat, lng);
      });
    });
  </script>
</x-filament-panels::page>
