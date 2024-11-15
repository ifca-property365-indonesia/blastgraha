<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $this->subject($this->mailData['subject'])
            ->view('content_email.container.invoice')
            ->with([
                'name' => $this->mailData['name'],
                'nama_bulan' => $this->mailData['nama_bulan'],
                'tahun' => $this->mailData['tahun'],
            ]);

        if ($this->mailData['process_id'] != '0') {
            // foreach ($this->mailData['detail'] as $files) {
            if ($this->mailData['detail']->filenames != null) {
                $this->attach(env('ROOT_INVOICE_FILE_PATH') . 'Invoice/HISTORY_INVOICE/' . $this->mailData['detail']->filenames, [
                    'as' => $this->mailData['detail']->filenames,
                    'mime' => 'application/pdf',
                ]);
            }

            if ($this->mailData['detail']->filenames2 != null) {
                $this->attach(env('ROOT_INVOICE_FILE_PATH') . 'Invoice/HISTORY_INVOICE/' . $this->mailData['detail']->filenames2, [
                    'as' => $this->mailData['detail']->filenames2,
                    'mime' => 'application/pdf',
                ]);
            }

            if ($this->mailData['detail']->filenames3 != null) {
                $this->attach(env('ROOT_INVOICE_FILE_PATH') . 'Invoice/HISTORY_INVOICE/' . $this->mailData['detail']->filenames3, [
                    'as' => $this->mailData['detail']->filenames3,
                    'mime' => 'application/pdf',
                ]);
            }
            // }
        } else {
            foreach ($this->mailData['detail'] as $files) {
                $this->attach(env('ROOT_INVOICE_FILE_PATH') . 'Invoice/' . $files->filenames, [
                    'as' => $files->filenames,
                    'mime' => 'application/pdf',
                ]);

                if ($files['filenames2'] != null) {
                    $this->attach(env('ROOT_INVOICE_FILE_PATH') . 'Invoice/' . $files->filenames2, [
                        'as' => $files->filenames2,
                        'mime' => 'application/pdf',
                    ]);
                }

                if ($files['filenames3'] != null) {
                    $this->attach(env('ROOT_INVOICE_FILE_PATH') . 'Invoice/' . $files->filenames3, [
                        'as' => $files->filenames3,
                        'mime' => 'application/pdf',
                    ]);
                }
            }
        }
        return $this;
    }
}
