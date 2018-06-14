<?php
namespace WPAskAQuestion\Shortcodes;

use WPAskAQuestion\Utility;
use WPAskAQuestion\WPAskAQuestion;

abstract class Shortcode
{
    protected static $shortcodeTag = false;

    private static $definedShortCodes = [
        'AskAQuestion'
    ];
    private static $initializedShortCodes = [];

    abstract public function doShortcode($atts);
    abstract protected function getTemplateName();

    public function __construct()
    {
        if (static::$shortcodeTag) {
            add_shortcode(static::$shortcodeTag, [$this, 'doShortcode']);
        }
    }

    public static function addShortcodes()
    {
        foreach (self::$definedShortCodes as $shortCode) {
            if (!isset(self::$initializedShortCodes[$shortCode])) {
                $shortCodeObject = "\\WPAskAQuestion\Shortcodes\\" . $shortCode;
                self::$initializedShortCodes[$shortCode] = new $shortCodeObject;
            }
        }
    }

    public function createView($args=[]) {
        return Utility::populateTemplateFile('Shortcode/'.$this->getTemplateName(),$args);
    }
}