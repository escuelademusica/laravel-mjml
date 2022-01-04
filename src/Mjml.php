<?php

namespace EscuelaDeMusica\MJML;

use Illuminate\View\Factory;
use Illuminate\View\View;
use Illuminate\View\ViewName;

class Mjml
{
    /**
     * Path to the view file.
     */
    public string $path;

    /**
     * View instance.
     */
    public $viewInstance;

    public function __construct(public Factory $factory, public string $view, public array $data = [])
    {
        $this->factory = $factory;
        $this->view = $view;
        $this->data = $data;
        $this->path = $this->factory->getFinder()->find(ViewName::normalize($view));

        $this->createView();
    }

    protected function createView()
    {
        $this->viewInstance = new View(
            $this->factory,
            $this->factory->getEngineResolver()->resolve('mjml.blade'),
            $this->view,
            $this->path,
            $this->data
        );
    }

    public function render()
    {
        return $this->viewInstance->render();
    }
}
