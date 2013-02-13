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
    
    protected $_pluginBaseUrl;
    protected $_pluginApiUrl;
    protected $_pluginBasePath;
    protected $_pluginLibraryPath;
    protected $_pluginTemplatePath;
    protected $_pluginPageHooks;
    
    public function __construct() {
        $this->loadFirePHP();
        
        #FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        $pluginLibraryPath = plugin_dir_path(__FILE__);
        $this->_pluginLibraryPath = $pluginLibraryPath;
        #FB::log($pluginLibraryPath, '$pluginLibraryPath');
        
        $pluginTemplatePath = realpath($pluginLibraryPath . '../templates') . DIRECTORY_SEPARATOR;
        $this->_pluginTemplatePath = $pluginTemplatePath;
        #FB::log($pluginTemplatePath, '$pluginTemplatePath');
        
        $pluginBasePath = realpath($pluginLibraryPath . '../') . DIRECTORY_SEPARATOR;
        $this->_pluginBasePath = $pluginBasePath;
        #FB::log($pluginBasePath, '$pluginBasePath');
        
        $pluginApiFile  = $pluginBasePath . 'social-media-importer-api.php';
        $pluginsBaseUrl = plugin_dir_url($pluginApiFile);
        $this->_pluginBaseUrl = $pluginsBaseUrl;
        #FB::log($pluginsBaseUrl, '$pluginsBaseUrl');
        
        $pluginApiUrl = $pluginsBaseUrl . 'social-media-importer-api.php';
        $this->_pluginApiUrl = $pluginApiUrl;
        #FB::log($pluginApiUrl, '$pluginApiUrl');
        #FB::groupEnd();
        
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
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
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        
        FB::groupEnd();
    }
    
    public function admin_menu(){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
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
        
        $this->_pluginPageHooks = $listPageHook;
        FB::log($listPageHook, '$listPageHook');
        FB::groupEnd();
    }
    
    public function admin_enqueue_scripts($pageHook){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        FB::log($pageHook, '$pageHook');
        
        $pluginPageHooks = $this->_pluginPageHooks;
        FB::log($pluginPageHooks, '$pluginPageHooks');
        if(in_array($pageHook, $pluginPageHooks)){
            //CSS
            wp_enqueue_style('social-media-importer', $this->_pluginBaseUrl . 'css/social-media-importer.css', array(), '1.0.0');
            
            //JS
            wp_enqueue_script('social-media-importer', $this->_pluginBaseUrl . 'js/social-media-importer.js', array('jquery'), '1.0.0', true);
            
            //INLINE SCRIPTS
            $jsParams = array(
                'pluginApiUrl' => $this->_pluginApiUrl,
            );
            wp_localize_script('social-media-importer', 'socialMediaImporterConfig', $jsParams);
            
        }
        
        FB::groupEnd();
    }
    
    public function savePluginSettings($section, $settings){
        $optionKey = self::SETTING_PREFIX . '_' . $section;
        return update_option($optionKey, json_encode($settings));
    }
    
    public function getPluginSettings($section = '', $key = ''){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        FB::log(array('$section' => $section, '$key' => $key));
        $pluginSettings = array();
        
        //FACEBOOK
        $pluginSettings['facebook'] = array(
            array('key' => 'app_id'    , 'title' => 'Application ID'),
            array('key' => 'app_secret', 'title' => 'Application Secret'),
            array('key' => 'fanpage_id', 'title' => 'Fan Page ID'),
            array('key' => 'user_id'   , 'title' => 'User ID'),
        );
        
        //YOUTUBE
        $pluginSettings['youtube'] = array(
            array('key' => 'username', 'title' => 'Username'),
        );
        
        //INSTAGRAM
        $pluginSettings['instagram'] = array(
            array('key' => 'client_id'    , 'title' => 'Client ID'),
            array('key' => 'client_secret', 'title' => 'Client Secret'),
        );
        
        //FLICKR
        $pluginSettings['flickr'] = array(
            array('key' => 'app_key'   , 'title' => 'Application Key'),
            array('key' => 'app_secret', 'title' => 'Application Secret'),
            array('key' => 'username'  , 'title' => 'Username'),
        );
        
        $selectedSettings      = array();
        $selectedSettingsValue = '';
        if(!empty($section) && (isset($pluginSettings[$section]))){
            $selectedSettings = $pluginSettings[$section];
            
            $optionKey             = self::SETTING_PREFIX . '_' . $section;
            $selectedSettingsValue = get_option($optionKey, '');
            
            if(!empty($selectedSettingsValue)){
                $selectedSettingsValue = json_decode($selectedSettingsValue, true);
            }
            
            foreach($selectedSettings as $index => $setting){
                $selectedSettings[$index]['value'] = isset($selectedSettingsValue[ $setting['key'] ]) ? $selectedSettingsValue[ $setting['key'] ] : '';
            }
        }
        
        FB::log($selectedSettings, '$selectedSettings');
        FB::log($selectedSettingsValue, '$selectedSettingsValue');
        FB::groupEnd();
        return $selectedSettings;
    }
    
    public function page_general_option(){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        $facebookSettings = $this->getPluginSettings('facebook');
        #FB::log($facebookSettings, '$facebookSettings');
        
        $youtubeSettings = $this->getPluginSettings('youtube');
        #FB::log($youtubeSettings, '$youtubeSettings');
        
        $instagramSettings = $this->getPluginSettings('instagram');
        #FB::log($instagramSettings, '$instagramSettings');
        
        $flickrSettings = $this->getPluginSettings('flickr');
        #FB::log($flickrSettings, '$flickrSettings');
        //
        include($this->_pluginTemplatePath . 'general-option.php');
        FB::groupEnd();
    }
    
    public function page_import_facebook(){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        $facebookSettings = $this->getPluginSettings('facebook');
        FB::log($facebookSettings, '$facebookSettings');
        
        echo '<code> ' . __FUNCTION__ . '</code>';
        FB::groupEnd();
    }
    
    public function page_import_youtube(){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        $youtubeSettings = $this->getPluginSettings('youtube');
        FB::log($youtubeSettings, '$youtubeSettings');
        
        echo '<code> ' . __FUNCTION__ . '</code>';
        FB::groupEnd();
    }
    
    public function page_import_flickr(){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        $flickrSettings = $this->getPluginSettings('flickr');
        FB::log($flickrSettings, '$flickrSettings');
        
        echo '<code> ' . __FUNCTION__ . '</code>';
        FB::groupEnd();
    }
    
    public function page_import_instagram(){
        FB::group(__CLASS__ . '.' . __FUNCTION__, array('Collapsed' => true));
        $instagramSettings = $this->getPluginSettings('instagram');
        FB::log($instagramSettings, '$instagramSettings');
        
        echo '<code> ' . __FUNCTION__ . '</code>';
        FB::groupEnd();
    }
    
}
