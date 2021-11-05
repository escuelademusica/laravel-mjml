<?php

namespace Edx\MJML\Mail;

use Edx\MJML\Support\InteractsWithMjml;
use Illuminate\Mail\Mailable as IlluminateMailable;

class Mailable extends IlluminateMailable
{
    use InteractsWithMjml;

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
