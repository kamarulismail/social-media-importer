<?php
//
require_once('../../../wp-config.php');

$calledFunction = isset($_REQUEST['f']) ? $_REQUEST['f'] : 'default';
if (function_exists($calledFunction)) {
    $calledFunction();
}
else {
    $serverResponse = array('status' => 0, 'message' => 'invalid request', 'debug' => $_REQUEST);
    json_response($serverResponse);
}

//FUNCTIONS
function json_response($respsonse){
    echo json_encode($respsonse);
    exit(0);
}

function save_general_options(){
    $serverResponse = array('status' => 0, 'message' => 'error');
    
    //
    $serverResponse['debug']['PLUGIN_LIBRARY_PATH'] = PLUGIN_LIBRARY_PATH;
    $serverResponse['debug']['function'] = __FUNCTION__;
    
    $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : array();
    if(empty($data)){
        json_response($serverResponse);
    }
    
    parse_str($data, $postData);
    $serverResponse['debug']['data'] = $postData;
    
    $section = $postData['section'];
    unset($postData['section']);
    
    //LOAD CLASS
    global $social_media_importer;
    if($social_media_importer->savePluginSettings($section, $postData)){
        $serverResponse['status']  = 1;
        $serverResponse['message'] = 'success';
    }
    
    json_response($serverResponse);
}