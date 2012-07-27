<?php

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('core_path').'components/translations/model/';
            $modx->addExtensionPackage('translations',$modelPath);
 
            $manager = $modx->getManager();
            $manager->createObjectContainer('Translation');
			
			
			
			$modx->log(modX::LOG_LEVEL_INFO,'Attempting to bind plugin to event...');
			
			$plugin = $modx->getObject('modPlugin',array( 'name' => 'TranslationsGateway'));
			if($plugin instanceof modPlugin){
				$modx->log(modX::LOG_LEVEL_INFO,'Plugin not found!!!!!!');
			} else {
				$pluginId = $plugin->get('id');
				$modx->log(modX::LOG_LEVEL_INFO,'New plugin has id #'.$pluginId);
			};
            
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
};



return true;
