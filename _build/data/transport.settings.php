<?php
$settings = array();

$settings['translations.test']= $modx->newObject('modSystemSetting');
$settings['translations.test']->fromArray(array(
    'key' => 'translations.test',
    'value' => 'Testing....',
    'xtype' => 'textfield',
    'namespace' => 'translations',
    'area' => 'common',
),'',true,true);

return $settings;
