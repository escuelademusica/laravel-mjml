<?php

namespace EscuelaDeMusica\MJML\Mail;

use EscuelaDeMusica\MJML\Support\InteractsWithMjml;
use Illuminate\Mail\Mailable as IlluminateMailable;

class Mailable extends IlluminateMailable
{
    use InteractsWithMjml;

    public function buildView()
    {
        if (isset($this->mjml)) {
            return $this->buildMjmlView();
        }

        return parent::buildView();
    }

    /**
     * Render the mailable into a view.
     *
     * @throws \ReflectionException
     */
    public function render(): string
    {
        if (isset($this->mjml)) {
            return $this->renderMjml();
        }

        return parent::render();
    }
}
