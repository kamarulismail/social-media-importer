<?php
/*
Plugin Name: Social Media Importer
Plugin URI: https://github.com/kamarulismail/social-media-importer
Description: A plugin to import social media contents (Facebook, Flickr, Instagram, YouTube) to wordpress.
Version: 1.0
Author: Kamarul Ariffin Ismail
Author URI: https://github.com/kamarulismail/
License: GPL2 or later
*/

/*  
Copyright 2013  Kamarul Ariffin Ismail  (email : kamarul.ismail@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Social_Media_Importer')){
    
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Social_Media_Importer', 'activate'));
    register_deactivation_hook(__FILE__, array('Social_Media_Importer', 'deactivate'));
    register_uninstall_hook(__FILE__,  array('Social_Media_Importer', 'uninstall'));
    
    $pluginLibraryPath = plugin_dir_path(__FILE__) . 'library/';
    define('PLUGIN_LIBRARY_PATH', $pluginLibraryPath);
    
    //DEBUGGER
    if (!class_exists('FB', false)) {
        require_once ($pluginLibraryPath . 'FirePHPCore/fb.php');
        FB::setEnabled(WP_DEBUG);
        FB::warn('FirePHP Enabled', __FILE__);
        ob_start();
    }
    
    //LOAD CLASS
    global $social_media_importer;
    require_once($pluginLibraryPath . 'social_media_importer.php');
    $social_media_importer = new Social_Media_Importer();
}
