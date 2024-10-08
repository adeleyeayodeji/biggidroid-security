<?php

/**
 * Plugin Name: Biggidroid Security
 * Plugin URI:  https://biggidroid.com
 * Author:      Biggidroid
 * Author URI:  https://biggidroid.com
 * Description: This plugin secures wordpress base directory and files
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: biggidroid-security
 */


//check for security
if (! defined('ABSPATH')) {
    exit("You are not allowed to access this file.");
}

//include the core class
require_once plugin_dir_path(__FILE__) . 'includes/core-class.php';

//initialize the core class
Biggidroid\Security\Core::get_instance();
