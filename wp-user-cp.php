<?php
/**
 * @package WP User Control Panel
 */
/*
Plugin Name: WP User Control Panel (Beta) 
Description: A user control panel for eCommerce websites
Version: 1.0 Beta 1
Author: Jeremy G
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define('WPUCP_VERSION', '1.0 Beta 1');
define('WPUCP_PLUGIN_URL', plugin_dir_url( __FILE__ ));


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

//Run installation procedures: create database tables
function wpucp_install() {

  global $wpdb;
  require_once(ABSPATH . "wp-admin/includes/upgrade.php");
  
  //Create cart table
  $table_name = $wpdb->prefix . "wpupc_cart";
  $query = "CREATE TABLE $table_name (
  cart_id mediumint(9) NOT NULL AUTO_INCREMENT,
  user_id mediumint(9),
  items text DEFAULT NULL,
  discount_codes text DEFAULT NULL,
  shipping text DEFAULT NULL,
  created timestamp DEFAULT CURRENT_TIMESTAMP,
  lastupdated timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (cart_id)
  );";
  dbDelta($query);
  
  update_option('wpucp_version', $wpucp_version);
} 
  
function wpucp_update_check(){
  
  global $wpucp_version;
  $installed_version = get_option('wpucp_version');                                           
  
  if($wpucp_version != $installed_version){
    wpucp_install();
  }  
}

register_activation_hook(__FILE__, 'wpucp_install');
add_action('plugins_loaded', 'wpucp_update_check');






















/*
function wpucp_redirect($args){
  if($args->query_vars['pagename'] == 'accounter'){
    $WP_USE_THEMES = false; 
  }
}

function dohead(){
  $requested_uri = ltrim(strrchr(rtrim($_SERVER['REQUEST_URI'], "/"), "/"), "/");
  switch($requested_uri){
    case "account":
    echo 'We are in the accounts section.';    
    break;
  }
}

add_action('init', 'wpucp_init');
add_action('pre_get_posts', 'wpucp_redirect');
//add_action('get_header', 'dohead');
*/



?>