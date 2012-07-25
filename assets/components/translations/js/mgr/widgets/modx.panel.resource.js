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

MODx.panel.TranslatableResource = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    Ext.applyIf(config,{
        url: MODx.config.connectors_url+'resource/index.php'
        ,id: 'modx-panel-resource'
        ,class_key: 'modTranslatedDocument'
    });
    MODx.panel.TranslatableResource.superclass.constructor.call(this,config);
};
Ext.extend(MODx.panel.TranslatableResource, MODx.panel.Resource, {
    defaultClassKey: 'modTranslatedDocument'
    ,getFields: function(config) {
        var it = [];
        it.push({
            title: _(this.classLexiconKey)
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,labelAlign: 'top'
            ,labelSeparator: ''
            ,bodyCssClass: 'tab-panel-wrapper main-wrapper'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,msgTarget: 'under'
                ,width: 400
            }
            ,items: this.getMainFields(config)
        });
        it.push({
            id: 'modx-page-translations'
            ,title: _('translations')
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,forceLayout: true
            ,deferredRender: false
            ,labelWidth: 200
            ,bodyCssClass: ''
            ,autoHeight: true
            ,border:false
            ,defaults: {
                border: true
                ,msgTarget: 'under'
            }
            ,items: this.getTranslationFields(config)
          
        });
        it.push({
            id: 'modx-page-settings'
            ,title: _('settings')
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,forceLayout: true
            ,deferredRender: false
            ,labelWidth: 200
            ,bodyCssClass: 'main-wrapper'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,msgTarget: 'under'
            }
			,items: this.getSettingFields(config)
        });
        if (config.show_tvs && MODx.config.tvs_below_content != 1) {
            it.push(this.getTemplateVariablesPanel(config));
        }
        if (MODx.perm.resourcegroup_resource_list == 1) {
            it.push(this.getAccessPermissionsTab(config));
        }
        var its = [];
        its.push(this.getPageHeader(config),{
            id:'modx-resource-tabs'
            ,xtype: 'modx-tabs'
            ,forceLayout: true
            ,deferredRender: false
            ,collapsible: true
            ,itemId: 'tabs'
            ,items: it
        });
        var ct = this.getContentField(config);
        if (ct) {
            its.push({
                title: _('resource_content')
                ,id: 'modx-resource-content'
                ,layout: 'form'
                ,bodyCssClass: 'main-wrapper'
                ,autoHeight: true
                ,collapsible: true
                ,hideMode: 'offsets'
                ,items: ct
                ,style: 'margin-top: 10px'
            });
        }
        if (MODx.config.tvs_below_content == 1) {
            var tvs = this.getTemplateVariablesPanel(config);
            tvs.style = 'margin-top: 10px';
            its.push(tvs);
        }
        return its;
    }
    ,getTranslationFields: function(config) {
        return {
            xtype: 'modx-panel-resource-translations'
            ,collapsed: false
            ,resource: config.resource
            ,class_key: config.record.class_key || 'modDocument'
            ,template: config.record.template
            ,anchor: '100%'
            ,border: true
		};
    }
});
Ext.reg('modx-panel-resource',MODx.panel.TranslatableResource);

