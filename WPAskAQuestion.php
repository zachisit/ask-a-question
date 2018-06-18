<?php
namespace WPAskAQuestion;

use WPAskAQuestion\DashboardWidgets\DashboardWidgets;
use WPAskAQuestion\Shortcodes\Shortcode;
use WPAskAQuestion\Utility;

class WPAskAQuestion
{
    private static $classified = null;
    public function __construct()
    {
        register_activation_hook(__FILE__, [__CLASS__, 'install']);
        register_deactivation_hook(__FILE__, [__CLASS__, 'uninstall']);
        $this->addActions();
        $this->registerFilters();
        Shortcode::addShortcodes();
    }
    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!(self::$classified instanceof self)) {
            self::$classified = new self();
        }
        return self::$classified;
    }
    /**
     * Currently an alias of getInstance, eventually this will contain the functions to initialize the plugin
     * @return WPAskAQuestion
     */
    public static function init()
    {
        return self::getInstance();
    }
    public function addActions()
    {
        DashboardWidgets::registerActions();
        add_action('wp_enqueue_scripts', [__CLASS__, 'registerFrontendScripts']);

        //frontend ask-a-question form submission posting
        add_action( 'wp_ajax_a_p_n_ask_a_question_form', [__CLASS__, 'a_a_q_form_submit'] );
        add_action( 'wp_ajax_nopriv_a_p_n_ask_a_question_form', [__CLASS__, 'a_a_q_form_submit'] );
    }
    public function registerFilters()
    {
        //
    }
    /**
     * Called on install
     */
    public static function install()
    {
        //put db field creation here
    }
    /**
     * Called on uninstall
     */
    public static function uninstall()
    {
    }
    public static function registerAdminStyles()
    {
        //wp_enqueue_style
    }
    public static function registerFrontendScripts()
    {
        wp_enqueue_script('jquery');


        wp_enqueue_script( 'ask_a_question_popup', plugins_url( '/js/ask_a_question_popup_submit.js', __FILE__ ) );
    }

    public static function a_a_q_form_submit()
    {
        $data = [
            'a_a_q_email' => $_POST['a_a_q_email'],
            'a_a_q_question' => $_POST['a_a_q_question'],
            'user_ip' => Utility::getUserIp(),
            'submission_time' => Utility::getCurrentTime()
        ];

        Database::insertAskAQuestionSubmission($data);
    }
}