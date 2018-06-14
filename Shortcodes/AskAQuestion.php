<?php

namespace WPAskAQuestion\Shortcodes;


class AskAQuestion extends Shortcode
{
    protected static $shortcodeTag = 'ask-a-question-form';

    protected function getTemplateName()
    {
        return 'ask-a-question_form';
    }

    public function doShortcode($atts)
    {
        return $this->createView();
    }
}