<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemHeadLoader extends JPlugin {

    function plgSystemHeadLoader( $subject, $params ) {
        parent::__construct( $subject, $params );
    }

    function onBeforeRender() {
        $app = JFactory::getApplication();
        $JSContent = "";
        if($app->isSite()) {
            $doc = JFactory::getDocument();
            $exc_scripts = (array) explode("\r\n",  $this->params->get('scripts'));
            $head = $doc->getHeadData();
            foreach($head['scripts'] as $key => $script){
                foreach($exc_scripts as $script) {
                    if(strpos($key, $script)){
                        unset($head['scripts'][$key]);
                        $scriptPath = JURI::root(true) . $script;
                        $JSContent .= "head.js('" . $scriptPath  . "');\r";
                    }
                }
            }
            $doc->setHeadData($head);
            $doc->addScriptDeclaration($JSContent);
        }
    }
    
}
