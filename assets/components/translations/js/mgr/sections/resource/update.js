/**
 * Loads the translated resource update page
 * 
 * @class MODx.page.UpdateTranslatedResource
 * @extends MODx.page.UpdateResource
 * @param {Object} config An object of config properties
 * @xtype modx-page-translatedresource-update
 */
MODx.page.UpdateTranslatedResource = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: MODx.config.assets_url+'components/translations/connectors/resource/index.php'
       // url: MODx.config.connectors_url+'resource/index.php'
        ,formpanel: 'modx-panel-resource'
        ,id: 'modx-page-translatedresource-update'
    });
    
    MODx.page.UpdateTranslatedResource.superclass.constructor.call(this,config);

};
Ext.extend(MODx.page.UpdateTranslatedResource,MODx.page.UpdateResource,{
	preview: function(){
		alert(MODx.config.connectors_url);
		window.open(this.config.preview_url);
        return false;
	}
	
	,cancel: function(btn,e) {
        var fp = Ext.getCmp(this.config.formpanel);
        if (fp && fp.isDirty()) {
            Ext.Msg.confirm(_('warning'),_('resource_cancel_dirty_confirm'),function(e) {
                if (e == 'yes') {
                    MODx.releaseLock(MODx.request.id);
                    MODx.sleep(400);
                    location.href = '?a='+MODx.action['welcome'];                    
                }
            },this);
        } else {
            MODx.releaseLock(MODx.request.id);
        };
    }
});
Ext.reg('modx-page-translatedresource-update',MODx.page.UpdateTranslatedResource);
