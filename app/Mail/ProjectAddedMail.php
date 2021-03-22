<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('projectadded')->with(
            [
                'project' => $this->info['project'],
                'clinic' => $this->info['clinic'],
                'tools' => $this->info['tools'],
                'user' => $this->info['user']
            ]
        );
    }
}
