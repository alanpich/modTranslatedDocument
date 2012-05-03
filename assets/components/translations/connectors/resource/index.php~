<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/index.php';
require_once $basePath . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$modx->request->handleRequest( array(
    'processors_path'   => $modx->getOption( 'core_path' ) . 'components/translations/processors/',
    'location'          => 'mgr/resource/'
) );
?>
