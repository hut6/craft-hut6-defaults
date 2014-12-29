<?php
namespace Craft;

class SeoPlugin extends BasePlugin
{
    
    function getName()
    {
        return Craft::t('Hut6 Defaults');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Hut6';
    }

    function getDeveloperUrl()
    {
        return 'http://hut6.com.au/';
    }

//    public function registerCpRoutes()
//    {
//        return array(
//            'Seo' => array('action' => "seo/index"),
//            "seo/install/" => 'seo/install',
//        );
//    }
    
    public function getSettingsHtml()
    {
        return craft()->templates->render('seo/_settings', array(
            'settings' => $this->getSettings()
        ));
    }
    
    function init() {

        // check we have a cp request as we don't want to this js to run anywhere but the cp
        // and while we're at it check for a logged in user as well
        if ( craft()->request->isCpRequest() && craft()->userSession->isLoggedIn() ) {
            
            // Include Groove Widget
            craft()->templates->includeJs("(function() {var s=document.createElement('script');
      s.type='text/javascript';s.async=true;s.src=('https:'==document.location.protocol?'https':'http') +
      '://hut6.groovehq.com/widgets/3b3e9867-0217-4b60-aeed-47f9fcd36fbc/ticket.js'; var q = document.getElementsByTagName('script')[0];q.parentNode.insertBefore(s, q);})();");

//            craft()->templates->includeCss('');
//            craft()->templates->includeJsResource('');
//            craft()->templates->includeCssResource('');

        }

    }

    
}