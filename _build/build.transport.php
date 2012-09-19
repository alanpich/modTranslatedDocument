<?php /* Translations Transport Package Builder

	v1.0-beta2	September 2012
*/

header('Content-Type: text/plain');

define('BUILD_ID','001');
define('BUILD_TAG',"\nBUILD ".BUILD_ID.' ['.date('Y-m-d H:i:s').']');

$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);
 
/* define package names */
define('PKG_NAME','Translations');
define('PKG_NAME_LOWER','translations');
define('PKG_VERSION','1.0.0');
define('PKG_RELEASE','beta2');
 
/* define build paths */
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'resolvers' => $root . '_build/resolvers/',
    'chunks' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/chunks/',
    'plugins' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/plugins/',
    'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
    'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
    'elements' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/',
    'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
);
unset($root);
 
/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
 
$modx= new modX();
$modx->initialize('mgr');
echo '';
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
 
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);


// Register namespace for this extra -------------------------------------------------
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

 
// Create the plugin object ----------------------------------------------------------
$plugin= $modx->newObject('modPlugin');
$plugin->set('id',1);
$plugin->set('name', 'Translations');
$plugin->set('locked',true);
$plugin->set('description', PKG_NAME.' '.PKG_VERSION.'-'.PKG_RELEASE.' plugin for MODx Revolution');
$plugin->set('plugincode', file_get_contents($sources['source_core'] . '/elements/plugins/translations.plugin.php'));
$plugin->set('category', 0);


// Add plugin events -----------------------------------------------------------------
$events = include $sources['data'].'transport.plugin.events.php';
if (is_array($events) && !empty($events)) {
    $plugin->addMany($events);
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events!');
}
$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events.'); flush();
unset($events);
 
 
// Define vehicle attributes ----------------------------------------------------------
$attributes= array(
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'PluginEvents' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::UNIQUE_KEY => array('pluginid','event'),
        ),
    ),
);

// Create transport vehicle ------------------------------------------------------------
$vehicle = $builder->createVehicle($plugin, $attributes);


$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers...');
// Add File resolvers ------------------------------------------------------------------
$vehicle->resolve('file',array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));


// Build transport vehicle -------------------------------------------------------------
$builder->putVehicle($vehicle);


// Add Resolver Scripts ------------------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO,'Adding in PHP resolvers...');
$vehicle->resolve('php',array(
	'source' => $sources['resolvers'] . 'resolve.tables.php',
));
$modx->log(modX::LOG_LEVEL_INFO,'  => Resolvers added OK');


// Adding in docs ----------------------------------------------------------------------
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt').BUILD_TAG,
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
));
$modx->log(xPDO::LOG_LEVEL_INFO,'Set Package Attributes.'); flush();



 
// zip up package ------------------------------------------------------------------------------
	$modx->log(modX::LOG_LEVEL_INFO,'Packing up transport package zip...');
	$builder->pack();
 
// Finish up -----------------------------------------------------------------------------------
	$tend= explode(" ", microtime());
	$tend= $tend[1] + $tend[0];
	$totalTime= sprintf("%2.4f s",($tend - $tstart));
	$modx->log(modX::LOG_LEVEL_INFO,"  => Package Built in {$totalTime}s".BUILD_TAG);
exit ();
