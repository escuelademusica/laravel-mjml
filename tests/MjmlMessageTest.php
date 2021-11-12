<?php

namespace Tests;

use EscuelaDeMusica\MJML\Mail\Messages\MjmlMessage;

class MjmlMessageTest extends TestCase
{
    /** @test */
    public function it_renders_mjml_messages()
    {
        $message = new MjmlMessage();

        $message->mjml('test', ['name' => 'Taylor']);

        $this->assertStringContainsString('<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">', $message->render());
        $this->assertStringContainsString('Taylor', $message->render());
    }
}
