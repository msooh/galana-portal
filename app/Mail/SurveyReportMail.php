<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurveyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $surveyDetails;  
    public $url;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($surveyDetails, $url, $pdf)
    {
        $this->surveyDetails = $surveyDetails;
        $this->url = $url;
        $this->pdf = $pdf;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Survey Report Mail',           
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.survey.report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $attachments = [];

        // Check if PDF object is available and attach it
        if ($this->pdf) {
            $attachments[] = [
                'file' => $this->pdf->output(), // Get the PDF output as binary data
                'as' => 'survey-report.pdf',
                'mime' => 'application/pdf',
            ];
        }

        return $attachments;
    }

}
