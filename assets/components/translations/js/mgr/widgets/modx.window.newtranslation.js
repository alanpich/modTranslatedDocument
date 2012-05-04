MODx.window.NewTranslation = function(config) {
    config = config || {};
    Ext.applyIf(config,{
    	id: 'modx-window-newtranslation'
        ,title: _('translations.new_translation')
        ,url: TranslationsConnector
        ,saveBtnText: 'Add'
        ,cancelBtnText: _('cancel')
		,success: function(){
			document.location.href = document.location.href;
		}
        ,baseParams: {
            action: 'translation/create'
        }
        ,fields: [{
            xtype: 'modx-combo-language'
            ,fieldLabel: _('translations.select_language')
            ,name: 'language'
            ,anchor: '100%'
	   },{
	   		xtype: 'hidden'
	   		,name: 'articleID'
	   		,value: MODx.request.id
	   },{
	   		xtype: 'hidden'
	   		,name: 'pagetitle'
	   		,value: ''
	   },{
	   		xtype: 'hidden'
	   		,name: 'longtitle'
	   		,value: ''
	   },{
	   		xtype: 'hidden'
	   		,name: 'menutitle'
	   		,value: ''
	   },{
	   		xtype: 'hidden'
	   		,name: 'description'
	   		,value: ''
	   },{
	   		xtype: 'hidden'
	   		,name: 'introtext'
	   		,value: ''
	   },{
	   		xtype: 'hidden'
	   		,name: 'content'
	   		,value: ''
	   }]
    });
    MODx.window.NewTranslation.superclass.constructor.call(this,config);
};
Ext.extend(MODx.window.NewTranslation,MODx.Window);
Ext.reg('modx-window-newtranslation',MODx.window.NewTranslation);
