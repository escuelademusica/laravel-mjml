<?php

namespace EscuelaDeMusica\MJML\Support;

use DOMDocument;
use DOMNode;
use DOMText;
use Illuminate\Support\Str;

class TextParser
{
    /**
     * Clean an HTML formatted text making it Slack-friendly, removing
     * the tags from the source and replacing user's attachments with
     * Slack-friendly variants.
     */
    public static function clean(string $text): string
    {
        $xml = new DOMDocument();

        @$xml->loadHTML('<?xml encoding="utf-8" ?>' . $text);

        return self::nodeToPlainText($xml);
    }

    /**
     * Convert a DOMNode Document to plain text.
     */
    protected static function nodeToPlainText(DOMDocument $node): string
    {
        return static::removeTrailingNewLines(static::plainTextForNode($node));
    }

    /**
     * Given a Node in the HTML, it will convert given Node to a text
     * variant. If the Parser has built in support for the Node itself,
     * it will run this custom text extractor, otherwise it will
     * convert it using a default parser.
     *
     * @return string
     */
    protected static function plainTextForNode(DOMNode $node)
    {
        $method = static::plainTextMethodForNode($node);

        if (method_exists(static::class, $method)) {
            return call_user_func([static::class, $method], $node);
        }

        if ($node instanceof DOMText) {
            return trim(static::plainTextForTextNode($node));
        }

        return static::plainTextForNodeChildren($node);
    }

    /**
     * Guess a custom text conversion method name for the given Node.
     */
    protected static function plainTextMethodForNode(DOMNode $node): string
    {
        return sprintf('plainTextFor%sNode', (string) Str::studly($node->nodeName));
    }

    /**
     * Convert to text a Node that has children, looping through the same
     * cycle as we did for other DOM nodes and finally return them in one
     * single string.
     */
    protected static function plainTextForNodeChildren(DOMNode $node): string
    {
        $texts = [];
        $index = 0;

        foreach ($node->childNodes as $child) {
            /* @psalm-suppress TooManyArguments */
            $texts[] = static::plainTextForNode($child, $index++);
        }

        return implode('', $texts);
    }

    protected static function plainTextForBlock(DOMNode $node): string
    {
        return sprintf("%s\n\n", static::removeTrailingNewLines(static::plainTextForNodeChildren($node)));
    }

    protected static function plainTextForANode(DOMNode $node): string
    {
        $href = $node->getAttribute('href');

        return sprintf('<a href="%s"> %s </a>', $href, static::plainTextForNodeChildren($node));
    }

    protected static function plainTextForH1Node(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForH2Node(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForH3Node(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForH4Node(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForH5Node(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForH6Node(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForPNode(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForUlNode(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForOlNode(DOMNode $node)
    {
        return static::plainTextForBlock($node);
    }

    protected static function plainTextForBrNode(DOMNode $node): string
    {
        return "\n";
    }

    protected static function plainTextForStyleNode(DOMNode $node): string
    {
        return '';
    }

    protected static function plainTextForScriptNode(DOMNode $node): string
    {
        return '';
    }

    protected static function plainTextForTextNode(DOMText $node): string
    {
        return static::removeTrailingNewLines($node->ownerDocument->saveHTML($node));
    }

    protected static function plainTextForDivNode(DOMNode $node): string
    {
        return sprintf("%s\n", static::removeTrailingNewLines(static::plainTextForNodeChildren($node)));
    }

    protected static function plainTextForFigcaptionNode(DOMNode $node): string
    {
        return sprintf('[%s]', static::removeTrailingNewLines(static::plainTextForNodeChildren($node)));
    }

    protected static function plainTextForBlockquoteNode(DOMNode $node): ?string
    {
        $text = static::plainTextForBlock($node);

        return preg_replace('/\A(\s*)(.+?)(\s*)\Z/m', '\1“\2”\3', $text);
    }

    protected static function plainTextForLiNode(DOMNode $node, $index = 0): string
    {
        $bullet = static::bulletForLiNode($node, $index);

        $text = static::removeTrailingNewLines(static::plainTextForNodeChildren($node));

        return sprintf("%s %s\n", $bullet, $text);
    }

    protected static function bulletForLiNode(DOMNode $node, $index): string
    {
        if ($node->parentNode->nodeName === 'ol') {
            return sprintf('%s.', $index + 1);
        }

        return '•';
    }

    private static function removeTrailingNewLines(string $text): string
    {
        return trim($text, "\n\r");
    }
}
