<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.waytocode.com
 * @since      1.1.1
 *
 * @package    hab_Hide_Admin_Bar_Based_On_User_Roles
 * @subpackage hab_Hide_Admin_Bar_Based_On_User_Roles/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    hab_Hide_Admin_Bar_Based_On_User_Roles
 * @subpackage hab_Hide_Admin_Bar_Based_On_User_Roles/admin
 * @author     Ankit Panchal <ankitmaru@live.in>
 */
class hab_Hide_Admin_Bar_Based_On_User_Roles_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.1.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in hab_Hide_Admin_Bar_Based_On_User_Roles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The hab_Hide_Admin_Bar_Based_On_User_Roles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if( isset($_GET['page']) && $_GET['page'] == 'hide-admin-bar-settings' ) { 
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hide-admin-bar-based-on-user-roles-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.1.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in hab_Hide_Admin_Bar_Based_On_User_Roles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The hab_Hide_Admin_Bar_Based_On_User_Roles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if( isset($_GET['page']) && $_GET['page'] == 'hide-admin-bar-settings' ) { 
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hide-admin-bar-based-on-user-roles-admin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script( $this->plugin_name, 'ajaxVar', array( 'url' => admin_url( 'admin-ajax.php' ) ) );	
		}


	}


	public function generate_admin_menu_page() {
		add_options_page( 
			'Admin Bar Settings',
			'Hide Admin Bar Settings',
			'manage_options',
			'hide-admin-bar-settings',
			array( $this, 'hide_admin_bar_settings')
		);
	}

	public function hide_admin_bar_settings() {

		$settings = get_option("hab_settings");
		?>
		<div class="wrap">
			<h2><?php echo __('Hide Admin Bar Based on User Roles');?></h2>

			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="disableforall"><?php echo __('Hide Admin Bar for All');?></label></th>
						<td class="rolesList">
							<?php 
								$disableForAll = ( isset($settings["hab_disableforall"]) ) ? $settings["hab_disableforall"] : "";
								$checked = ( $disableForAll == 'yes' ) ? "checked" : "";
								echo '<label class="hideAllLabel"><input id="hide_for_all" '.$checked.' type="checkbox" class=""></label>';
							?>
							</td>
					</tr>
					<?php if( $disableForAll == "no" || empty($disableForAll) ) { ?>
					<tr>
						<th scope="row"><label for="userroles"><?php echo __('User Roles');?></label><p style="margin:0px;"><?php echo __('(Hide admin bar for selected user roles.)');?></p></th>
						<td class="rolesList">
							<?php 
								global $wp_roles;
								$exRoles = ( isset($settings["hab_userRoles"]) ) ? $settings["hab_userRoles"] : "";
								$checked = '';

								$roles = $wp_roles->get_names();
								if( is_array( $roles ) ) {
									foreach( $roles as $key => $value ):

										if( is_array($exRoles) )
											$checked = ( in_array($key, $exRoles) ) ? "checked" : "";

										echo '<label class="roleLabel"><input name="userRoles[]" '.$checked.' type="checkbox" value="'.$key.'" class="regular-checkbox">'.$value.'</label>';
									endforeach;
								}
							?>
							</td>
					</tr>
					<tr>
						<th scope="row"><label for="usercapabilities"><?php echo __('Capabilities Blacklist <br /><p style="margin:0px;">'.__('(Comma-Separated) <br /><br />(Hide admin bar for selected user capabilities.)').'</p>');?></label></th>
						<td class="rolesList">
							<?php 
								$caps = (isset($settings["hab_capabilities"])) ? $settings["hab_capabilities"] : "";
								echo '<label class="roleLabel"><textarea id="capabilties" class="regular-text" rows="7">'.$caps.'</textarea></label>';
							?>
							</td>
					</tr>
					<tr>
						<td colspan="2"><?php echo __("Visit our blog to get regular updates, tricks, solutions about WordPress");?>&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://waytocode.com"><?php echo __("Click Here");?></a></td>
					</tr>

					<?php } ?>

				</tbody>
			</table>


			<button class="button button-primary" id="submit_roles"><?php echo __('Save Changes');?></button>
		</div>
		<?php
	}


	public function save_user_roles(){
		global $wpdb;

		$UserRoles = $_REQUEST['UserRoles'];
		$caps = $_REQUEST['caps'];
		$disableForAll = $_REQUEST['disableForAll'];
		$auto_hide_time = $_REQUEST['auto_hide_time']; 		
		$autoHideFlag = $_REQUEST['autoHideFlag']; 		
		
		$settings = array();

		$settings['hab_userRoles'] = $UserRoles;
		$settings['hab_capabilities'] = $caps;
		$settings['hab_disableforall'] = $disableForAll;
		$settings['hab_auto_hide_time'] = $auto_hide_time;
		$settings['hab_auto_hide_flag'] = $autoHideFlag;

		update_option("hab_settings",$settings);

		wp_die();
	}


}
