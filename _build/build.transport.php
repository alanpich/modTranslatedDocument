<?php /* Translations Transport Package Builder

	v1.0	May 2011
*/

header('Content-Type: text/plain');

define('BUILD_ID','004');
define('BUILD_TAG',"\nBUILD ".BUILD_ID.' ['.date('Y-m-d H:i:s').']');

$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);
 
/* define package names */
define('PKG_NAME','Translations');
define('PKG_NAME_LOWER','translations');
define('PKG_VERSION','1.0');
define('PKG_RELEASE','beta1');
 
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
//echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
 
$modx->log(modX::LOG_LEVEL_INFO,BUILD_TAG); 
 
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');
 
 
 
 
 
// Create Category Vehicle ---------------------------------------------------------------
	$category= $modx->newObject('modCategory');
	$category->set('id',1);
	$category->set('category',PKG_NAME);
 	$attr = array(
		xPDOTransport::UNIQUE_KEY => 'category',
		xPDOTransport::PRESERVE_KEYS => false,
		xPDOTransport::UPDATE_OBJECT => true,
		xPDOTransport::RELATED_OBJECTS => true,
		xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
		    'Plugins' => array(
		        xPDOTransport::PRESERVE_KEYS => false,
		        xPDOTransport::UPDATE_OBJECT => true,
		        xPDOTransport::UNIQUE_KEY => 'name',
		    ),
		),
	);
	$vehicle = $builder->createVehicle($category,$attr);


// Add Gateway plugin -------------------------------------------------------------------------
	$modx->log(modX::LOG_LEVEL_INFO,'Packaging in plugin...');
	$plugins = include $sources['data'].'transport.plugins.php';
	if (empty($plugins)) $modx->log(modX::LOG_LEVEL_ERROR,'  => Could not package in plugin.');
	$category->addMany($plugins);

// Add File Resolvers -------------------------------------------------------------------------
	$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers to category...');
	$vehicle->resolve('file',array(
		'source' => $sources['source_assets'],
		'target' => "return MODX_ASSETS_PATH . 'components/';",
	));
	$vehicle->resolve('file',array(
		'source' => $sources['source_core'],
		'target' => "return MODX_CORE_PATH . 'components/';",
	));
	$modx->log(modX::LOG_LEVEL_INFO,'  => Files added OK');

// Add Resolver Scripts ------------------------------------------------------------------------
	$modx->log(modX::LOG_LEVEL_INFO,'Adding in PHP resolvers...');
	$vehicle->resolve('php',array(
		'source' => $sources['resolvers'] . 'resolve.tables.php',
	));
	$modx->log(modX::LOG_LEVEL_INFO,'  => Resolvers added OK');

// Put Category Vehicle and all contents in the transport package-------------------------------
	$builder->putVehicle($vehicle); 
 
// Add System Settings -------------------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO,'Adding System Settings...');
$settings = include $sources['data'].'transport.settings.php';
if (!is_array($settings)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'  => Failed');
} else {
    $attributes= array(
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => false,
    );
    foreach ($settings as $setting) {
        $vehicle = $builder->createVehicle($setting,$attributes);
        $builder->putVehicle($vehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO,'  => OK');
}
unset($settings,$setting,$attributes); 
 
// Add documentation files ---------------------------------------------------------------------
$modx->log(modX::LOG_LEVEL_INFO,'Adding documentation and setup options...');
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt').BUILD_TAG,
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
)); 
$modx->log(modX::LOG_LEVEL_INFO,'  => OK');
 
// zip up package ------------------------------------------------------------------------------
	$modx->log(modX::LOG_LEVEL_INFO,'Packing up transport package zip...');
	$builder->pack();
 
// Finish up -----------------------------------------------------------------------------------
	$tend= explode(" ", microtime());
	$tend= $tend[1] + $tend[0];
	$totalTime= sprintf("%2.4f s",($tend - $tstart));
	$modx->log(modX::LOG_LEVEL_INFO,"  => Package Built in {$totalTime}s");
exit ();
