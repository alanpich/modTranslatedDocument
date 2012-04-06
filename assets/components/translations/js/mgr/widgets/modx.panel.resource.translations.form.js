MODx.panel.ResourceTranslationsForm = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    Ext.applyIf(config,{
   //     url: MODx.config.connectors_url+'resource/index.php'
        baseParams: {}
        ,id: 'modx-panel-resource-translations-form'
        ,class_key: 'modTranslatedDocument'
        ,resource: {}
        ,bodyStyle: ''
		,cls: 'container form-with-labels'
        ,defaults: { collapsible: false ,autoHeight: true }
        ,forceLayout: true
        ,layout: 'anchor'
        ,items: []
        ,fileUpload: true
        ,useLoadingMask: true
        ,listeners: {
            'setup': {fn:this.setup,scope:this}
            ,'success': {fn:this.success,scope:this}
            ,'failure': {fn:this.failure,scope:this}
            ,'beforeSubmit': {fn:this.beforeSubmit,scope:this}
        }
    });
    MODx.panel.ResourceTranslationsForm.superclass.constructor.call(this,config);
};

Ext.extend(MODx.panel.ResourceTranslationsForm,MODx.FormPanel,{


});
Ext.reg('modx-panel-resource-translations-form',MODx.panel.ResourceTranslationsForm);


