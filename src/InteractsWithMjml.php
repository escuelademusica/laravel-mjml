<?php

namespace EscuelaDeMusica\MJML;

use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;

trait InteractsWithMjml
{
    /**
     * The MJML template for the message (if applicable).
     *
     * @var string
     */
    public string $mjml;

    /**
     * Set the MJML template for the message.
     *
     * @param string $view
     *
     * @retur self
     */
    public function mjml(string $view, array $data = []): self
    {
        $this->mjml = $view;
        $this->viewData = array_merge($this->viewData, $data);

        return $this;
    }

    /**
     * Build mjml message.
     *
     * @return array
     */
    public function buildMjmlView(): array
    {
        return [
            'html' => new HtmlString($this->renderMjmlView()),
        ];
    }

    /**
     * Render the MJML Mailable.
     *
     * @return string
     */
    public function renderMjml(): string
    {
        if ($this instanceof Mailable) {
            return $this->withLocale($this->locale, function () {
                Container::getInstance()->call([$this, 'build']);

                return $this->renderMjmlView();
            });
        }

        return $this->renderMjmlView();
    }

    /**
     * Render the Mailable view file.
     *
     * @return string
     */
    protected function renderMjmlView(): string
    {
        return app(Mjml::class)->render($this->mjml, $this->viewData);
    }
}
