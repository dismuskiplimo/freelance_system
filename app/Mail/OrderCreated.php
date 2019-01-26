<?php

namespace App\Mail;

use App\Assignment;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $assignment;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Assignment $assignment, User $user)
    {
        $this->assignment = $assignment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order');
    }
}
