<?php

namespace Tests;

use Edx\MJML\Mail\Mailable;
use Edx\MJML\Support\InteractsWithMjml;
use Illuminate\Mail\Mailable as IlluminateMailable;

 /*
  * Check tests/resouces/test.blade.php to see test file.
  *
  * <mjml>
  * <mj-body>
  * <mj-text>{{ $name }}</mj-text>
  * </mj-body>
  * </mjml>
  */

class MailableTest extends TestCase
{
    /** @test */
    public function can_render_a_mjml_template()
    {
        $mailable = new TestMailable();

        $this->assertStringContainsString(
            '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">',
            $mailable->build()->render()
        );
    }

    /** @test */
    public function can_render_template_with_data()
    {
        $mailable = new TestMailableWithData();

        $this->assertStringContainsString('John', $mailable->build()->render());
    }

    /** @test */
    public function can_use_trait_in_mailable()
    {
        $mailable = new MailableExtendsLaravelMailable();

        $this->assertStringContainsString('<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">', $mailable->build()->render());
    }
}

class TestMailable extends Mailable
{
    public function build()
    {
        return $this->mjml('test');
    }
}

class TestMailableWithData extends Mailable
{
    public function build()
    {
        return $this->mjml('test', ['name' => 'John']);
    }
}

class MailableExtendsLaravelMailable extends IlluminateMailable
{
    use InteractsWithMjml;

    public function build()
    {
        return $this->mjml('test', ['name' => 'John']);
    }

    public function render()
    {
        return $this->renderMjml();
    }
}
