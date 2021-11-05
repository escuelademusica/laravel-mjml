<?php

namespace Edx\MJML;

use Illuminate\View\Factory;
use Illuminate\View\View;
use Illuminate\View\ViewName;

class Mjml
{
    public function render(string $view, array $data = [])
    {
        $factory = app(Factory::class);

        $path = $factory->getFinder()->find(
            $view = ViewName::normalize($view)
        );

        return (new View($factory, $factory->getEngineResolver()->resolve('mjml.blade'), $view, $path, $data))
            ->render();
    }
}
