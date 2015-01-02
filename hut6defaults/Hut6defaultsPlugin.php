<?php
namespace Craft;

class Hut6defaultsPlugin extends BasePlugin
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

    public function getSettingsHtml()
    {
        return craft()->templates->render('seo/_settings', array(
            'settings' => $this->getSettings()
        ));
    }
    
    function init() {

        // check we have a admin user as we don't want to this js to run anywhere but when an admin is logged in
        if ( craft()->userSession->isLoggedIn() && craft()->userSession->isAdmin() ) {
            
            // Include Groove Widget
            craft()->templates->includeJs("(function() {var s=document.createElement('script');
      s.type='text/javascript';s.async=true;s.src=('https:'==document.location.protocol?'https':'http') +
      '://hut6.groovehq.com/widgets/3b3e9867-0217-4b60-aeed-47f9fcd36fbc/ticket.js'; var q = document.getElementsByTagName('script')[0];q.parentNode.insertBefore(s, q);})();");

        }

    }

    
}