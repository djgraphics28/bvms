<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Incident;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SubmitIncidentReportPage extends Component
{
    use WithFileUploads, LivewireAlert;
    public $barangays = [];
    public $categories = [];

    public $selectedBarangay = null;
    public $selectedCategory = null;
    public $title = null;
    public $dateTime = null;
    public $location = null;
    public $description = null;
    public $incidentStatus = null;
    public $severityLevel = null;
    public $email = null;
    public $contactNumber = null;
    public $fullName = null;
    public $image = null;


    public function mount()
    {
        $this->barangays = \App\Models\Barangay::all();
        $this->categories = \App\Models\IncidentCategory::all();
    }

    public function store()
    {
        try {
            $this->validate([
                'selectedBarangay' => 'required',
                'selectedCategory' => 'required',
                'title' => 'required',
                'dateTime' => 'required',
                'location' => 'required',
                'description' => 'required',
                'severityLevel' => 'required',
                'email' => 'required|email',
                'fullName' => 'required'
            ]);

            $incidentReport = new Incident();
            $incidentReport->barangay_id = $this->selectedBarangay;
            $incidentReport->type = "incident";
            $incidentReport->incident_category_id = $this->selectedCategory;
            $incidentReport->title = $this->title;
            $incidentReport->date_time = $this->dateTime;
            $incidentReport->location = $this->location;
            $incidentReport->description = $this->description;
            $incidentReport->status = $this->incidentStatus;
            $incidentReport->priority = $this->severityLevel;
            $incidentReport->email = $this->email;
            $incidentReport->contact_number = $this->contactNumber;
            $incidentReport->reporter = $this->fullName;

            if ($this->image) {
                $incidentReport->addMedia($this->image)->toMediaCollection('incident_image');
            }

            if ($incidentReport->save()) {
                // Send auto-response email
                Mail::to($incidentReport->email)->send(new \App\Mail\IncidentReportAcknowledgement($incidentReport));
                $this->alert('success', 'Incident report submitted successfully.');

                sleep(2);

                return redirect()->route('incident.submission.succeed');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
            return null;
        }
    }
    public function render()
    {
        return view('livewire.submit-incident-report-page');
    }
}
