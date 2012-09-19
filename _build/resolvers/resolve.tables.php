<?php

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('core_path').'components/translations/model/';
			$modx->addPackage('translations',$modelPath);
            $modx->addExtensionPackage('translations',$modelPath);
 
            $manager = $modx->getManager();
            $manager->createObjectContainer('Translation');
						

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
};



return true;
