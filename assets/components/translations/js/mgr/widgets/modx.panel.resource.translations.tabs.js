/**
 * Loads the Resource Translations Panel Tabs
 * 
 * @class MODx.panel.ResourceTranslationsTabs
 * @extends MODx.Panel
 * @param {Object} config
 * @xtype panel-resource-translations-tabs
 */
MODx.panel.ResourceTranslationsTabs = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'modx-panel-resource-translations-tabs'
        ,title: _('translations')
        ,header: true
        ,headerCfg: {
		    tag: 'div',
		    id: 'modx-resource-vtabs-header',
		    cls: 'x-tab-panel-header vertical-tabs-header  x-unselectable',        // same as the Default class
		    html: '<h4 id="modx-resource-vtabs-header-title"><strong>'+ _('translations.languages') +'</strong></h4>'
		}
        ,class_key: ''
        ,resource: ''
        ,cls: 'x-form-label-top x-tab-panel vertical-tabs-panel'
        ,autoHeight: true
        ,labelAlign: 'top'

        ,items:[TEMP__GETFORM('fr'),TEMP__GETFORM('es'),TEMP__GETFORM('de')]
    });
    MODx.panel.ResourceTranslationsTabs.superclass.constructor.call(this,config);
    this.addEvents({ load: true });
};


Ext.extend(MODx.panel.ResourceTranslationsTabs,MODx.VerticalTabs,{
    autoload: function() {
        return false;
    }
    ,refreshTVs: function() { }
});
Ext.reg('modx-panel-resource-translations-tabs',MODx.panel.ResourceTranslationsTabs);



TEMP__GETFORM = function(lang){
	return {
		title: _('translations.language.'+lang) || "Foreign",
		items: [{
				xtype: 'textfield'
				,fieldLabel: _('resource_pagetitle')+''
				,description: '<b>[[*pagetitle]]</b><br />'+_('resource_pagetitle_help')
				,name: 'pagetitle'+lang
				,id: 'modx-resource-pagetitle-'+lang
				,maxLength: 255
				,anchor: '100%'
				,allowBlank: true
				,enableKeyEvents: true
				,listeners: {
					'keyup': {scope:this,fn:function(f,e) {
						var titlePrefix = MODx.request.a == MODx.action['resource/create'] ? _('new_document') : _('document');
						var title = Ext.util.Format.stripTags(f.getValue());
				 //       Ext.getCmp('modx-resource-header').getEl().update('<h2>'+title+'</h2>');
					}}
				}

			},{
				xtype: 'textfield'
				,fieldLabel: _('resource_longtitle')
				,description: '<b>[[*longtitle]]</b><br />'+_('resource_longtitle_help')
				,name: 'longtitle'+lang
				,id: 'modx-resource-longtitle'+lang
				,maxLength: 255
				,anchor: '100%'
				,value: ''
			},{
				xtype: 'textfield'
				,fieldLabel: _('resource_menutitle')
				,description: '<b>[[*menutitle]]</b><br />'+_('resource_menutitle_help')
				,name: 'menutitle'+lang
				,id: 'modx-resource-menutitle2'+lang
				,maxLength: 255
				,anchor: '100%'
				,value:  ''
			},{
				xtype: 'textarea'
				,fieldLabel: _('resource_description')
				,description: '<b>[[*description]]</b><br />'+_('resource_description_help')
				,name: 'description'+lang
				,id: 'modx-resource-description'+lang
				,maxLength: 255
				,anchor: '100%'
				,value:  ''

			},{
				xtype: 'textarea'
				,fieldLabel: _('resource_summary')
				,description: '<b>[[*introtext]]</b><br />'+_('resource_summary_help')
				,name: 'introtext'+lang
				,id: 'modx-resource-introtext'+lang
				,grow: true
				,anchor: '100%'
				,value:  ''
			},{
				xtype: 'textarea'
				,fieldLabel: _('resource_content')
				,description: '<b>[[*content]]</b><br />'+_('resource_content_help')
				,name: 'ta-'+lang
				,id: 'ta-'+lang
				,anchor: '100%'
				,height: 400
				,grow: false
				,value:  ''
			}]
	};
};
