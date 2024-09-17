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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($surveyDetails, $url)
    {
        $this->surveyDetails = $surveyDetails;
        $this->url = $url;
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

    // Ensure file_name is present and valid
    if (isset($this->surveyDetails['file_name'])) {
        $surveyFilePath = storage_path('app/public/surveys/' . $this->surveyDetails['file_name']);

        if (file_exists($surveyFilePath)) {
            $attachments[] = [
                'file' => $surveyFilePath,
                'as' => 'survey-report.pdf',
                'mime' => 'application/pdf',
            ];
        }
    }

    return $attachments;
}

}
