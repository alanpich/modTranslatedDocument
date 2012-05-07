<?php

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('core_path').'components/translations/model/';
            $modx->addExtensionPackage('translations',$modelPath);
 
            $manager = $modx->getManager();
            $manager->createObjectContainer('Translation');
            
      //      $modx->addExtensionPackage('translations',$modelPath)
 
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
};



return true;
