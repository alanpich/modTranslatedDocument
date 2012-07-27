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
 
  
 
return $plugins;
