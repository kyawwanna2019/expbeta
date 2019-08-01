<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/25/2019
 * Time: 8:47 AM
 */

/*
Plugin Name: Traveler Zoopay CreditCard
Description: This plugin is used for Traveler Theme
Version: 1.0
Author: Kyaw Wanna
Author URI: https://heritage-asia.com
License: GPLv2 or later
Text Domain: traveler-zoopay
*/

class Traveler_Zoopay_Payment
{
    public $pluginUrl = '';
    public $pluginPath = '';
    public $customFolder = 'traveler-zoopay';

    public function __construct()
    {
        $this->pluginPath = trailingslashit(plugin_dir_path(__FILE__));
        $this->pluginUrl = trailingslashit(plugin_dir_url(__FILE__));

        add_action('plugins_loaded', [$this, '_pluginSetup']);
        add_action('init', [$this, '_pluginLoader'], 20);
        add_action('wp_enqueue_scripts', [$this, '_pluginEnqueue']);
    }

    public function _pluginSetup()
    {
        load_plugin_textdomain('traveler-zoopay', false, basename(dirname(__FILE__)) . '/languages');
    }

    public function _pluginLoader()
    {
        if (class_exists('STTravelCode') && class_exists('STAbstactPaymentGateway')) {
            require_once($this->pluginPath . 'inc/zoopay.php');
        }
    }

    public function _pluginEnqueue()
    {
        
    }

    public function loadTemplate($name, $data = null)
    {
        if (is_array($data))
            extract($data);

        $template = $this->pluginPath . 'views/' . $name . '.php';

        if (is_file($template)) {
            $templateCustom = locate_template($this->customFolder . '/views/' . $name . '.php');
            if (is_file($templateCustom)) {
                $template = $templateCustom;
            }
            ob_start();

            require($template);

            $html = @ob_get_clean();

            return $html;
        }


    }

    public static function get_inst()
    {
        static $instance;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}

Traveler_Zoopay_Payment::get_inst();