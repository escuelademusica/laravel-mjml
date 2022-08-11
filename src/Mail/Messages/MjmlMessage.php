<?php

namespace EscuelaDeMusica\MJML\Mail\Messages;

use EscuelaDeMusica\MJML\InteractsWithMjml;
use Illuminate\Notifications\Messages\MailMessage;

class MjmlMessage extends MailMessage
{
    use InteractsWithMjml;

    public function render(): string
    {
        return $this->renderMjml();
    }
}
