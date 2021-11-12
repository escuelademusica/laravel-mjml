<?php

namespace EscuelaDeMusica\MJML\Mail\Messages;

use EscuelaDeMusica\MJML\Support\InteractsWithMjml;
use Illuminate\Notifications\Messages\MailMessage;

class MjmlMessage extends MailMessage
{
    use InteractsWithMjml;

    public function render()
    {
        if (isset($this->mjml)) {
            return $this->renderMjml();
        }

        return parent::render();
    }
}
