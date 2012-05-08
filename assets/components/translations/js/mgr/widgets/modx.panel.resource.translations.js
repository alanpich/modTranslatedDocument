/**
 * Loads the Resource Translations Panel
 * 
 * @class MODx.panel.ResourceTranslations
 * @extends MODx.Panel
 * @param {Object} config
 * @xtype panel-resource-translations
 */
MODx.panel.ResourceTranslations = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'modx-panel-resource-translations'
        ,title: _('translations')+'ARSE'
        ,class_key: ''
        ,resource: ''
        ,cls: 'x-form-label-top x-tab-panel vertical-tabs-panel '
        ,autoHeight: true
        ,header: false
		,deferredRender: false
        ,items:[{
        			xtype: 'modx-panel-resource-translations-tabs'
        		},{
        			xtype: 'hidden'
        			,name: 'translations'
        			,value: AvailableTranslations
        		}]
    });
    MODx.panel.ResourceTranslations.superclass.constructor.call(this,config);
    this.addEvents({ load: true });
};
Ext.extend(MODx.panel.ResourceTranslations,MODx.Panel,{
    autoload: function() {
        return false;
    }
    ,refreshTVs: function() { }
});
Ext.reg('modx-panel-resource-translations',MODx.panel.ResourceTranslations);
