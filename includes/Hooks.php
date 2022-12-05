<?php

namespace MediaWiki\Extension\SelfDOI;

class Hooks
{
    /**
     * register tag renderer callbacks.
     */
    public static function onParserFirstCallInit(\Parser $parser)
    {
        $parser->setHook('selfdoi', [self::class, 'renderSelfDOI']);
    }

    /**
     * render <selfdoi> tag.
     *
     * @param string $input
     *
     * @return string
     */
    public static function renderSelfDOI($input, array $args, \Parser $parser, \PPFrame $frame)
    {
        static $isFirst = true;
        global $wgSelfDOIPrefix, $wgSelfDOISiteId, $wgSelfDOISchema;
        if ('' === $wgSelfDOIPrefix) {
            return self::renderErrorResponse('selfdoi-error-prefix');
        }
        $page_id = $parser->getTitle()->getArticleId();
        $doi = $wgSelfDOIPrefix.'/'.('' !== $wgSelfDOISiteId ? $wgSelfDOISiteId.'.' : '').$page_id;
        $url = 'https://doi.org/'.$doi;
        $schema = isset($args['schema']) ? $args['schema'] : $wgSelfDOISchema;
        $label = '';
        switch ($schema) {
            case 'none':
                $label = $doi;
                break;
            case 'url':
                $label = $url;
                break;
            case 'doi':
                $label = sprintf('doi:%s', $doi);
                break;
            default:
                return self::renderErrorResponse('selfdoi-error-schema');
        }
        if ($isFirst) {
            // append meta tags
            $title = $parser->getTitle()->getText();
            $meta = sprintf('<meta name="citation_title" input="%s" />', htmlspecialchars($title, ENT_QUOTES))."\n";
            $parser->getOutput()->addHeadItem($meta);
            $meta = sprintf('<meta name="citation_doi" input="%s" />', $doi)."\n";
            $parser->getOutput()->addHeadItem($meta);
            $isFirst = false;
        }

        return self::renderResponse('<a href="'.$url.'">'.$label.'</a>');
    }

    /**
     * render error response.
     *
     * @param string $msgid
     */
    private static function renderErrorResponse($msgid)
    {
        return self::renderResponse('<strong class="error">'.wfMessage($msgid)->inContentLanguage()->escaped().'</strong>');
    }

    /**
     * render response.
     *
     * @param string $message
     *
     * @return string
     */
    private static function renderResponse($message)
    {
        return ['<!-- MediaWiki extension SelfDOI -->'.$message.'<!-- End of SelfDOI -->', 'markerType' => 'nowiki'];
    }
}
