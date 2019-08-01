<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.waytocode.com
 * @since      1.1.1
 *
 * @package    hab_Hide_Admin_Bar_Based_On_User_Roles
 * @subpackage hab_Hide_Admin_Bar_Based_On_User_Roles/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.1.1
 * @package    hab_Hide_Admin_Bar_Based_On_User_Roles
 * @subpackage hab_Hide_Admin_Bar_Based_On_User_Roles/includes
 * @author     Ankit Panchal <ankitmaru@live.in>
 */
class hab_Hide_Admin_Bar_Based_On_User_Roles_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.1.1
	 */
	public static function activate() {
		global $wpdb;

		add_option("hab_settings", "" );

	}

}
