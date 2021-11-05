<?php

use Edx\MJML\Mjml;

if (! function_exists('mjml')) {
    function mjml(string $mjml, ?array $data = null): string
    {
        return app(Mjml::class)->render($mjml, $data ?? []);
    }
}
