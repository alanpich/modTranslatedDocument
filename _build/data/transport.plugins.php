<?php
function getPluginContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$plugins = array();
 
$plugins[0]= $modx->newObject('modPlugin');
$plugins[0]->fromArray(array(
    'id' => 0,
    'name' => 'TranslationsGateway',
    'description' => 'Manages content language switching',
    'plugincode' => getPluginContent($sources['plugins'].'translations.plugin.php'),
    'locked' => true
),'',true,true);
$properties = array();// include $sources['data'].'properties/properties.doodles.php';
$plugins[0]->setProperties($properties);
unset($properties);
 
 
// Create event objects for this plugin ----------------------------------------------------------
$events = array();
$events['OnHandleRequest'] = $modx->newObject('modPluginEvent');
$events['OnHandleRequest']->fromArray(array(
    'event' => 'OnHandleRequest',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);


// Bind events to plugin -------------------------------------------------------------------------
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'  => Plugin Events bound OK.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events!');
}
unset($events); 
 
 
 
return $plugins;
