/**
 * Translations
 *
 * Copyright 2012 by Alan Pich <alan@alanpich.com>
 *
 * Translations is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Translations is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Translations; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
**/

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
