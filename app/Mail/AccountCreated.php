<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;
   public $employe;
    public $password;
    public function __construct($employe,$password)
    {
        //
         $this->employe = $employe;
        $this->password = $password;
    }

   public function build()
    {
         return $this->subject('Votre compte a été créé')
                    ->view('emails.account_created')
                    ->with([
                        'nom' => $this->employe->nom,
                        'prenom' => $this->employe->prenom,
                        'email' => $this->employe->email,
                        'password' => $this->password
                    ]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
}