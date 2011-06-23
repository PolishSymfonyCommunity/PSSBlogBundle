<?php

namespace PSS\Bundle\BlogBundle\Twig\Extension;

class ContentExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'autop' => new \Twig_Filter_Method($this, 'autop'),
            'more'  => new \Twig_Filter_Method($this, 'cutToMoreTag')
        );
    }

    public function getName()
    {
        return 'content';
    }

    /**
     * This method is based on WordPress'es wpautop.
     *
     * @param string $content The text which needs to be formatted.
     * @return string
     */
    public function autop($content)
    {
        // If br set, this will convert all remaining line-breaks after paragraphing.
        $br = true;
        $content = preg_replace('|<br />\s*<br />|', "\n\n", $content . "\n");

        // Space things out a little
        $allBlocks = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
        $content = preg_replace('!(<' . $allBlocks . '[^>]*>)!', "\n$1", $content);
        $content = preg_replace('!(</' . $allBlocks . '>)!', "$1\n\n", $content);
        $content = str_replace(array("\r\n", "\r"), "\n", $content); // cross-platform newlines
        if (strpos($content, '<object') !== false)
        {
            $content = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $content); // no content inside object/embed
            $content = preg_replace('|\s*</embed>\s*|', '</embed>', $content);
        }
        $content = preg_replace("/\n\n+/", "\n\n", $content); // take care of duplicates
        // make paragraphs, including one at the end
        $contents = preg_split('/\n\s*\n/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $content = '';
        foreach ($contents as $tinkle)
        {
            $content .= '<p>' . trim($tinkle, "\n") . "</p>\n";
        }
        $content = preg_replace('|<p>\s*?</p>|', '', $content); // under certain strange conditions it could create a P of entirely whitespace
        $content = preg_replace('!<p>([^<]+)\s*?(</(?:div|address|form)[^>]*>)!', "<p>$1</p>$2", $content);
        $content = preg_replace( '|<p>|', "$1<p>", $content );
        $content = preg_replace('!<p>\s*(</?' . $allBlocks . '[^>]*>)\s*</p>!', "$1", $content); // don't content all over a tag
        $content = preg_replace("|<p>(<li.+?)</p>|", "$1", $content); // problem with nested lists
        $content = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $content);
        $content = str_replace('</blockquote></p>', '</p></blockquote>', $content);
        $content = preg_replace('!<p>\s*(</?' . $allBlocks . '[^>]*>)!', "$1", $content);
        $content = preg_replace('!(</?' . $allBlocks . '[^>]*>)\s*</p>!', "$1", $content);
        if ($br)
        {
            $content = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $content);
            $content = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $content); // optionally make line breaks
            $content = str_replace('<WPPreserveNewline />', "\n", $content);
        }
        $content = preg_replace('!(</?' . $allBlocks . '[^>]*>)\s*<br />!', "$1", $content);
        $content = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $content);
        if (strpos($content, '<pre') !== false)
        {
            $content = preg_replace_callback('!(<pre.*?>)(.*?)</pre>!is', array('self', 'cleanPre'), $content);
        }
        $content = preg_replace( "|\n</p>$|", '</p>', $content );
        // 	$content = preg_replace('/<p>\s*?(' . get_shortcode_regex() . ')\s*<\/p>/s', '$1', $content); // don't auto-p wrap shortcodes that stand alone

        return $content;
    }

    /**
     * @param string $content
     * @param string $moreTagReplacement
     * @return string
     */
    public function cutToMoreTag($content, $moreTagReplacement)
    {
        if (preg_match('/(.*)(<!--more(.*?)?-->)(.*)/Us', $content, $matches)) {
           return $matches[1] . $moreTagReplacement;
        }

        return $content;
    }

    /**
     * Cleans pre tags
     *
     * Taken from WordPress code.
     * @param string|array
     * @return string
     */
    protected static function cleanPre($matches)
    {
        if (is_array($matches))
        {
            $text = $matches[1] . $matches[2] . "</pre>";
        }
        else
        {
            $text = $matches;
        }

        $text = str_replace('<br />', '', $text);
        $text = str_replace('<p>', "\n", $text);
        $text = str_replace('</p>', '', $text);

        return $text;
    }
}
