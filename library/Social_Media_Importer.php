<?php
/**
 * Description of Social_Media_Importer
 *
 * @author Kamarul Ariffin Ismail <kamarul.ismail@gmail.com>
 */
class Social_Media_Importer {
    const PLUGIN_PREFIX  = 'smi';
    const SETTING_PREFIX = 'social_media_importer';
    const SETTING_GROUP  = 'social_media_importer_group';
    
    public function __construct() {
        $this->loadFirePHP();
        
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'admin_menu'));
    }
    
    public function loadFirePHP(){
        //DEBUGGER
        if (!class_exists('FB', false)) {
            require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'FirePHPCore/fb.php');
            FB::setEnabled(WP_DEBUG);
            FB::warn('FirePHP Enabled', __FILE__);
            ob_start();
        }
    }
    
    public static function activate(){
        //echo '<code> ' . __FUNCTION__ . '<code>';
    }
    
    public static function deactivate(){
        //echo '<code> ' . __FUNCTION__ . '<code>';
    }
    
    public function admin_init(){
        FB::group(__CLASS__ . '.' . __FUNCTION__);
        
        //$this->init_settings();
        
        FB::groupEnd();
    }
    
    public function admin_menu(){
        FB::group(__CLASS__ . '.' . __FUNCTION__);
        $menuPrefix   = self::PLUGIN_PREFIX . '_';
        $listPageHook = array();
        
        //MAIN MENU -> SM IMPORT
        $page_title = 'Social Media Importer';
        $menu_title = 'Social Media Importer';
        $capability = 'manage_options';
        $menu_slug  = $menuPrefix . 'general';
        $function   = 'page_general_option';
        $icon_url   = '';
        $position   = null;
    
        $pageHook = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, array(&$this, $function), $icon_url, $position);
        array_push($listPageHook, $pageHook);
        
        //INHERITS
        $parent_slug  = $menu_slug;
        $parent_title = $page_title;
        
        //MAIN MENU -> SM IMPORT -> General
        $page_title  = $parent_title . ' - General';
        $menu_title  = 'General';
    
        $pageHook = add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array(&$this, $function));
        array_push($listPageHook, $pageHook);
        
        $subMenus = array(
            array('title' => 'Facebook' , 'slug' => 'import_facebook' , 'function' => 'page_import_facebook'),
            array('title' => 'YouTube'  , 'slug' => 'import_youtube'  , 'function' => 'page_import_youtube'),
            array('title' => 'Flickr'   , 'slug' => 'import_flickr'   , 'function' => 'page_import_flickr'),
            array('title' => 'Instagram', 'slug' => 'import_instagram', 'function' => 'page_import_instagram'),
        );
        
        foreach($subMenus as $subMenu){
            $page_title  = $parent_title . ' - ' . $subMenu['title'];
            $menu_title  = $subMenu['title'];
            $menu_slug   = $menuPrefix . $subMenu['slug'];
            $function    = $subMenu['function'];
    
            $pageHook = add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array(&$this, $function));
            array_push($listPageHook, $pageHook);
        }
        
        FB::log($listPageHook);
        FB::groupEnd();
    }
    
    public function init_settings(){
        // register the settings for this plugin
        register_setting(self::SETTING_GROUP, 'initial-setting-a');
        register_setting(self::SETTING_GROUP, 'initial-setting-b');
    }
    
    public function page_general_option(){
        echo '<code> ' . __FUNCTION__ . '</code>';
    }
    
    public function page_import_facebook(){
        echo '<code> ' . __FUNCTION__ . '</code>';
    }
    
    public function page_import_youtube(){
        echo '<code> ' . __FUNCTION__ . '</code>';
    }
    
    public function page_import_flickr(){
        echo '<code> ' . __FUNCTION__ . '</code>';
    }
    
    public function page_import_instagram(){
        echo '<code> ' . __FUNCTION__ . '</code>';
    }
    
}
