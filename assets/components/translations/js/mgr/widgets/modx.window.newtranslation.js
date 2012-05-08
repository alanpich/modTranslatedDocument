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
