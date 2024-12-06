<div>
  <x-hero title="Incident Report Submitted Successfully!" />

  <x-container>
      <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Success Message -->
          <div class="col-span-full">
              <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6 text-center">
                  <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  <h2 class="text-2xl font-semibold text-green-800 mb-2">Thank You!</h2>
                  <p class="text-green-700">Your incident report has been successfully submitted.</p>
              </div>
          </div>

          <!-- Submit Another Report Button -->
          <div class="col-span-full text-center mt-6">
              <a href="{{ route('submit.incident.report') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Submit Another Incident Report
              </a>
          </div>
      </div>
  </x-container>
</div>
