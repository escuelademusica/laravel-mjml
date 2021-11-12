<?php

namespace EscuelaDeMusica\MJML\Support;

use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;

trait InteractsWithMjml
{
    /**
     * The MJML template for the message (if applicable).
     *
     * @var string
     */
    public $mjml;

    /**
     * Set the MJML template for the message.
     *
     * @param string $view
     *
     * @return $this
     */
    public function mjml($view, array $data = []): self
    {
        $this->mjml = $view;
        $this->viewData = array_merge($this->viewData, $data);

        return $this;
    }

    public function renderMjml()
    {
        if ($this instanceof Mailable) {
            return $this->withLocale(
                $this->locale,
                function () {
                    Container::getInstance()->call([$this, 'build']);

                    return \mjml($this->mjml, $this->viewData);
                }
            );
        } else {
            return \mjml($this->mjml, $this->viewData);
        }
    }
}
