<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $paciente;
    public $accion;
    public $value;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paciente, $accion, $value)
    {
        $this->paciente = $paciente;
        $this->accion = $accion;
        $this->value = $value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Notificación de Actividad";
        $from = "mi.espol.project@gmail.com";
        $name = "MI Espol Project";
        return $this->view('emails.notification',["paciente" => $this->paciente, "accion"=>$this->accion, "value"=>$this->value])
                    ->from($from, $name)
                    ->subject($subject);
    }
}
