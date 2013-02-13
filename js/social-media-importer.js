/* Avoid `console` errors in browsers that lack a console. */
if (!(window.console && console.log)) {
    (function() {
        var noop = function() {};
        var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'markTimeline', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
        var length = methods.length;
        var console = window.console = {};
        while (length--) {
            console[methods[length]] = noop;
        }
    }());
}

jQuery(document).ready(function($) {
    console.group('social-media-importer.js');
    
    var _pluginApiUrl = '#';
    if(typeof(socialMediaImporterConfig) != 'undefined'){
        //console.log('socialMediaImporterConfig', socialMediaImporterConfig);
        _pluginApiUrl = socialMediaImporterConfig.pluginApiUrl;
    }
    console.log('_pluginApiUrl', _pluginApiUrl);
    
    /* TABS */
    var tabWrapper   = $('.nav-tab-wrapper');
    var tabContainer = $('.nav-tab-container-wrapper');
    
    function hideAllTabs(){
        tabContainer.find('.nav-tab-container').hide();
    } //hideAllTabs();
    
    function getContainerIndex(containerId){
        containerIndex = '';
        
        tabContainer = tabContainer.find(containerId);
        if(tabContainer.length > 0){
            containerIndex = tabContainer.index(); 
        }
        
        return containerIndex;
    }
    
    tabWrapper.on('click', 'a', function(evt){
        evt.preventDefault();
        tabClicked = $(this);
        
        if(tabClicked.hasClass('nav-tab-active')){
            return true;
        }
        
        tabIndex    = tabClicked.index();
        containerId = tabClicked.attr('href');
        containerSelected = tabContainer.find(containerId);
        if(containerSelected.length == 0){
            containerSelected = tabContainer.find('.nav-tab-container:eq(' + tabIndex + ')');
        }
        
        if(containerSelected.length > 0){
            tabWrapper.find('.nav-tab-active').removeClass('nav-tab-active');
            tabClicked.addClass('nav-tab-active');
            
            tabContainer.find('.nav-tab-container-active').removeClass('nav-tab-container-active');
            containerSelected.addClass('nav-tab-container-active');
        }
    });
    
    /* GENERAL OPTIONS */
    $('.smi-form').on('submit', function(evt){
        evt.preventDefault();
        console.group('.smi-form.submit');
        data = $(this).serialize();
        //console.log('data ', data);
        
        var request = $.ajax({
            type    : 'post',
            dataType: 'json',
            url     : _pluginApiUrl,
            data: {
                f    : 'save_general_options', 
                data : data
            }
        });
        //request.success(smi_form_success);
        //request.error(smi_form_error);
        request.done(smi_form_success);
        request.fail(smi_form_error);
        
        function smi_form_success(data, textStatus, jqXHR){
            console.log('smi_form_success ',data, textStatus, jqXHR);
        }
        
        function smi_form_error(jqXHR, textStatus, errorThrown){
            console.log('smi_form_error ',jqXHR, textStatus, errorThrown);
        }
        
        console.groupEnd();
    });
    
    console.groupEnd();
});

