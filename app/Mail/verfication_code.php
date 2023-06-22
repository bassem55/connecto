<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verfication_code extends Mailable
{
    use Queueable, SerializesModels;

    public $details ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title ;
    public $link;
    public $subject;
    public function __construct($subject,$title1 , $link)
    {
        $this->subject = $subject;
        $this->title = $title1;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        ->view('emails.verfication_code')->with(["title" => $this->title , "link" => $this->link]);
    }
}
