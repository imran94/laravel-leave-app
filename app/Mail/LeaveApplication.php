<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveApplication extends Mailable
{

    use Queueable,
        SerializesModels;

    private $email;
    private $name;
    private $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $date, $email)
    {
        $this->name = $name;
        $this->date = $date;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('emails.LeaveApplication')->with('email', $this->email)->with('name', $this->name)->with('date', $this->date);
        return $this->markdown('emails.LeaveApplication', ['name' => $this->name, 'date' => $this->date, 'email' => $this->email]);
        // return $this->view('emails.LeaveApplication')
        //     ->with(
        //         [
        //             'name' => $this->name,
        //             'date' => $this->date,
        //             'email' => $this->email
        //         ]
        //     );
    }
}
