<?php

namespace EscuelaDeMusica\MJML;

use EscuelaDeMusica\MJML\Support\TextParser;
use Tests\TestCase;

class TextParserTest extends TestCase
{
    /** @test */
    public function can_parse_a_nodes_with_content()
    {
        $text = TextParser::clean('<a href="/link"> Data </a>');

        $this->assertEquals('<a href="/link"> Data </a>', $text);
    }

    /** @test */
    public function can_parse_a_nodes_with_children()
    {
        $text = TextParser::clean('<a href="/link">  <span> something </span></a>');

        $this->assertEquals('<a href="/link"> something </a>', $text);
    }
}
