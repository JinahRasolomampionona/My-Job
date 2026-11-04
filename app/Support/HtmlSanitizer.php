<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Nettoie le HTML produit par l'éditeur Quill avant de l'afficher avec {!! !!}.
 * Seules les balises et attributs de mise en forme sont conservés : les scripts,
 * les attributs on* (onclick, onerror...) et les liens javascript: sont supprimés.
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup', 'span',
        'h1', 'h2', 'h3', 'h4', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'a',
    ];

    private const ALLOWED_ATTRIBUTES = ['href', 'class', 'style', 'target', 'rel', 'data-list'];

    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="__root">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $root = $document->getElementById('__root');
        if (! $root) {
            return e(strip_tags($html));
        }

        self::cleanNode($root);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $document->saveHTML($child);
        }

        return $output;
    }

    private static function cleanNode(DOMNode $node): void
    {
        // On copie la liste car elle est modifiée pendant le parcours
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form'], true)) {
                    $node->removeChild($child);
                    continue;
                }

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    // Balise inconnue : on garde son contenu texte mais pas la balise
                    self::cleanNode($child);
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                foreach (iterator_to_array($child->attributes) as $attribute) {
                    $name = strtolower($attribute->name);
                    $value = trim($attribute->value);

                    $forbidden = ! in_array($name, self::ALLOWED_ATTRIBUTES, true)
                        || ($name === 'href' && ! preg_match('#^(https?://|mailto:|/|\#)#i', $value))
                        || ($name === 'style' && preg_match('/expression|url\s*\(|javascript/i', $value));

                    if ($forbidden) {
                        $child->removeAttribute($attribute->name);
                    }
                }

                if ($tag === 'a') {
                    $child->setAttribute('rel', 'noopener noreferrer');
                }

                self::cleanNode($child);
            } elseif ($child->nodeType === XML_COMMENT_NODE) {
                $node->removeChild($child);
            }
        }
    }
}
