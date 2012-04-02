/**
 * Loads the Resource TV Panel
 * 
 * @class MODx.panel.ResourceTV
 * @extends MODx.Panel
 * @param {Object} config
 * @xtype panel-resource-tv
 */
 

MODx.panel.ResourceTranslations = function(config) {
    config = config || {};
    
    TranslationItems = Array();
    for(var k=0;k<AvailableTranslations.length;k++){
    	TranslationItems.push({
    		title: _('translations.language.'+AvailableTranslations[k]),
    		html: 'coming soon...'
    	});
    };
    TranslationItems.push({
			title: _('translations.newTranslation'),
			items:[ 
				   TranslatableArticle.newTranslationLanguageSelector
				   ,TranslatableArticle.newTranslationCreateButton
				  ]
		 });
    
    
    Ext.applyIf(config,{
        id: 'modx-panel-resource-translations'
		,xtype: 'modx-vtabs'
        ,title: _('translatablearticle.translations')
        ,class_key: ''
        ,resource: ''
        ,cls: MODx.config.tvs_below_content == 1 ? 'x-panel-body tvs-wrapper' : 'tvs-wrapper x-panel-body'
        ,autoHeight: true
        ,templateField: 'modx-resource-template'
		,items: [{
				xtype: 'modx-vtabs'
				,border: false
				,title: 'Languages'
				,items: TranslationItems
			}]
		,border: false
		,plain: true
		,autoTabs: true
    });
    MODx.panel.ResourceTranslations.superclass.constructor.call(this,config);
    this.addEvents({ load: true });
	console.log(this);
};
Ext.extend(MODx.panel.ResourceTranslations,MODx.Panel,{
    autoload: function() {
        return false;
    }
    ,refreshTVs: function() {
        return false;
        var t = Ext.getCmp(this.config.templateField);
        if (!t && !this.config.template) { return false; }
        var template = this.config.template ? this.config.template : t.getValue();
        
        this.getUpdater().update({
            url: MODx.config.manager_url+'index.php?a='+MODx.action['resource/tvs']
            ,method: 'GET'
            ,params: {
               'class_key': this.config.class_key
               ,'template': template
               ,'resource': this.config.resource
            }
            ,scripts: true
            ,callback: function() {
                this.fireEvent('load');
                if (MODx.afterTVLoad) { MODx.afterTVLoad(); }
            }
            ,scope: this
        });
    }
});
Ext.reg('modx-panel-resource-translations',MODx.panel.ResourceTranslations);



//=========================================================================================================================
//=========================================================================================================================
TranslatableArticle = {};

TranslatableArticle.newTranslationPanel = new MODx.FormPanel({
	title: 'new translation'
	,html: 'titties!'
	,fields:[{
			html:'hello world'
		}]
});




TranslatableArticle.languageList = new Ext.data.ArrayStore({
        fields: [
            'iso',
            'displayText'
        ],
		storeId: 'translatablearticle-languageList',
        data:[]
    })


TranslatableArticle.newTranslationLanguageSelector = new Ext.form.ComboBox({
	width: 300
	,fieldLabel: _('translations.selectLanguage')
	,store: TranslatableArticle.languageList
	,valueField: 'iso'
	,mode: 'local'
	,displayField: 'displayText'
	,forceSelection: true
	,title: _('translations.availableLanguages')
	,lazyInit: true	
	,editable: false
})

TranslatableArticle.newTranslationCreateButton = new Ext.Button({
	width: 300
	,text: _('translations.createTranslation')
	,hideLabel: true
	,style: {
		marginLeft: '106px'
	}
})


// Prepare language selector list
Ext.onReady(function(){
	var langs = TranslatedArticleLanguages;
	for(var k=0;k<langs.length;k++){
		var record = {
				iso: langs[k],
				displayText: _('translations.language.'+langs[k])
			};
		var newRecord = new TranslatableArticle.languageList.recordType(record);
		TranslatableArticle.languageList.add(newRecord);
	};

	TranslatableArticle.newTranslationLanguageSelector.addListener('expand',function(){
		this.reset();
	});

});



