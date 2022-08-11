<?php

namespace EscuelaDeMusica\MJML;

use EscuelaDeMusica\MJML\Support\TextParser;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;

trait InteractsWithMjml
{
    /**
     * Set the MJML template for the message.
     *
     * @retur self
     */
    public function mjml(string $view, array $data = []): self
    {
        $this->view = $view;
        $this->viewData = array_merge($this->viewData, $data);

        return $this;
    }

    /**
     * Build mjml message.
     */
    public function buildMjmlView(): array
    {
        $htmlContent = $this->renderMjmlView();

        return [
            'html' => new HtmlString($htmlContent),
            'text' => new HtmlString(TextParser::clean($htmlContent)),
        ];
    }

    /**
     * Render the MJML Mailable.
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
     */
    protected function renderMjmlView(): string
    {
        return app(Mjml::class, ['view' => $this->view, 'data' => $this->viewData])->render();
    }
}
