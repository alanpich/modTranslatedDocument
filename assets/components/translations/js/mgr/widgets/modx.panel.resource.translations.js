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
