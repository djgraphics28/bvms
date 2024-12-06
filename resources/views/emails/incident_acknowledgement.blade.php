@component('mail::message')
# Thank You for Submitting Your Incident Report

We have received your incident report with the following details:

**Title:** {{ $title }}

**Description:**
{{ $description }}

**Reported By:** {{ $reported_by }}

We will review your report and get back to you if necessary.

{{-- @component('mail::button', ['url' => url('/')])
Visit Our Website
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
