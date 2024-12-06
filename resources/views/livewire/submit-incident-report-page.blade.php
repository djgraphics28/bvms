<div>
  <x-hero title="Submit Incident Report" />

  <x-container>
      <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Incident Details Section -->
          <div class="col-span-full lg:col-span-2">

              <!-- Guidelines Section -->
              <div class="col-span-full lg:col-span-1 mb-3">
                  <div class="rounded-lg bg-gray-50 p-6">
                      <h3 class="text-lg font-medium text-gray-900">Reporting Guidelines</h3>
                      <div class="mt-4 space-y-4 text-sm text-gray-600">
                          <p>1. Report incidents as soon as possible</p>
                          <p>2. Be specific and factual in descriptions</p>
                          <p>3. Include all relevant details</p>
                          <p>4. Attach any supporting documents if available</p>
                          <p>5. Review information before submission</p>
                      </div>
                  </div>
              </div>
              <form class="space-y-6">

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Select Barangay</label>
                      <select name="barangay" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                          <option value="">Select a barangay</option>
                      </select>
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Incident Title</label>
                      <input type="text" name="title" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Date & Time</label>
                      <input type="datetime-local" name="datetime" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Location</label>
                      <div class="flex space-x-2">
                          <input type="text" id="location" name="location" readonly required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                          <button type="button" onclick="getLocation()"
                              class="mt-1 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd"
                                      d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                      clip-rule="evenodd" />
                              </svg>
                          </button>
                      </div>
                      <input type="hidden" id="latitude" name="latitude" required>
                      <input type="hidden" id="longitude" name="longitude" required>
                      <small class="text-gray-500">Click on the map to set location or drag the marker</small>
                  </div>

                  <!-- Map Container -->
                  <div id="map" class="mt-4 w-full h-64 rounded-lg border border-gray-300"></div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Incident Description</label>
                      <textarea rows="4" name="description" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Severity Level</label>
                      <select name="severity" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                          <option value="">Select severity</option>
                          <option value="low">Low</option>
                          <option value="medium">Medium</option>
                          <option value="high">High</option>
                          <option value="critical">Critical</option>
                      </select>
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                      <input type="tel" name="contact" required pattern="[0-9]{11}"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="09XXXXXXXXX">
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700">Email</label>
                      <input type="email" name="email" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  </div>

                  <div class="flex justify-end">
                      <button type="submit"
                          class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                          Submit Report
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </x-container>
</div>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGSdz2RsYpR2isrO9CpAUSQUgAf6pZKvg&callback=initMap"></script>
<script>
  let map;
  let marker;

  function initMap() {
      const defaultLocation = { lat: 14.5995, lng: 120.9842 }; // Default location: Manila
      map = new google.maps.Map(document.getElementById("map"), {
          center: defaultLocation,
          zoom: 15,
      });

      marker = new google.maps.Marker({
          position: defaultLocation,
          map: map,
          draggable: true,
          animation: google.maps.Animation.DROP,
      });

      map.addListener('click', function (event) {
          placeMarker(event.latLng);
      });
  }

  function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
              (position) => {
                  const currentLocation = {
                      lat: position.coords.latitude,
                      lng: position.coords.longitude,
                  };

                  map.setCenter(currentLocation);
                  marker.setPosition(currentLocation);

                  document.getElementById("latitude").value = currentLocation.lat;
                  document.getElementById("longitude").value = currentLocation.lng;
                  document.getElementById("location").value = `${currentLocation.lat}, ${currentLocation.lng}`;
              },
              (error) => {
                  alert("Error fetching location: " + error.message);
              }
          );
      } else {
          alert("Geolocation is not supported by your browser.");
      }
  }

  function placeMarker(location) {
      marker.setPosition(location);
      document.getElementById("latitude").value = location.lat();
      document.getElementById("longitude").value = location.lng();
      document.getElementById("location").value = `${location.lat()}, ${location.lng()}`;
  }
</script>
