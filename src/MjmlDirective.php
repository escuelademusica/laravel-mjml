<?php

namespace EscuelaDeMusica\MJML;

use Illuminate\View\Factory;

class MjmlDirective
{
    protected $finder;

    public function __construct(Factory $viewFactory)
    {
        $this->finder = $viewFactory->getFinder();
    }

    protected function find($view)
    {
        return $this->finder->find(\trim($view, "'"));
    }

    public function include($view, $data = [])
    {
        $path = $this->find($view);

        $type = $data['type'] ?? '';

        return "<mj-include path=\"{$path}\" type=\"{$type}\" />";
    }
}
