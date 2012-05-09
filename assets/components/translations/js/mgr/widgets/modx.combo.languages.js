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

MODx.combo.Languages = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'language'
        ,hiddenName: 'language'
        ,displayField: 'name'
        ,valueField: 'code'
        ,fields: ['name','code']
        ,forceSelection: true
        ,typeAhead: false
        ,editable: false
        ,allowBlank: false
        ,pageSize: 20
        ,url: TranslationsConnector
        ,baseParams: {
            action: 'language/getList'
        }
    });
    MODx.combo.Language.superclass.constructor.call(this,config);
};
Ext.extend(MODx.combo.Languages,MODx.combo.ComboBox);
Ext.reg('modx-combo-languages',MODx.combo.Languages);
