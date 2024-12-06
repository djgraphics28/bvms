<?php

namespace App\Mail;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncidentReportAcknowledgement extends Mailable
{
    use Queueable, SerializesModels;

    public $incidentReport;

    public function __construct(Incident $incidentReport)
    {
        $this->incidentReport = $incidentReport;
    }

    public function build()
    {
        return $this->markdown('emails.incident_acknowledgement')
            ->subject('Incident Report Submitted Successfully')
            ->with([
                'title' => $this->incidentReport->title,
                'description' => $this->incidentReport->description,
                'reported_by' => $this->incidentReport->reporter,
            ]);
    }
}
