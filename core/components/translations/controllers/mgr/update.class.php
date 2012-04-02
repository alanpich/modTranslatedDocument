<?php
class TranslatedDocumentUpdateManagerController extends ResourceUpdateManagerController {


public function getLanguageTopics() {
		return array('resource','translations:default');
	}//
	
	
//------------------------------------------------------------------------------------------------------------------------
public function loadCustomCssJs() {
        $managerUrl = $this->context->getOption('manager_url', MODX_MANAGER_URL, $this->modx->_userConfig);
		$jsUrl = $this->context->getOption('assets_url').'components/translations/js/';
		$cssUrl = $this->context->getOption('assets_url').'components/translations/css/';
		
        $this->addJavascript($managerUrl.'assets/modext/util/datetime.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/element/modx.panel.tv.renders.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.grid.resource.security.local.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.panel.resource.tv.js');
        $this->addJavascript($managerUrl.'assets/modext/sections/resource/update.js');
       
	    $this->addJavascript($jsUrl.'mgr/modTranslatedDocument.js');
        $this->addJavascript($jsUrl.'mgr/widgets/modx.panel.resource.translations.js');
        $this->addCss($cssUrl.'translations.css');


		$this->addHtml('
        <script type="text/javascript">
        // <![CDATA[
        MODx.config.publish_document = "'.$this->canPublish.'";
        MODx.onDocFormRender = "'.$this->onDocFormRender.'";
        MODx.ctx = "'.$this->resource->get('context_key').'";
        Ext.onReady(function() {
            MODx.load({
                xtype: "modx-page-resource-update"
                ,resource: "'.$this->resource->get('id').'"
                ,record: '.$this->modx->toJSON($this->resourceArray).'
                ,publish_document: "'.$this->canPublish.'"
                ,preview_url: "'.$this->previewUrl.'"
                ,locked: '.($this->locked ? 1 : 0).'
                ,lockedText: "'.$this->lockedText.'"
                ,canSave: '.($this->canSave ? 1 : 0).'
                ,canEdit: '.($this->canEdit ? 1 : 0).'
                ,canCreate: '.($this->canCreate ? 1 : 0).'
                ,canDuplicate: '.($this->canDuplicate ? 1 : 0).'
                ,canDelete: '.($this->canDelete ? 1 : 0).'
                ,show_tvs: '.(!empty($this->tvCounts) ? 1 : 0).'
                ,mode: "update"
            });
        });
		TranslatedArticleLanguages = "'.$this->context->getOption('translations.languages').'".split(",");
		
		AvailableTranslations = Array('.$this->getAvailableTranslationList().');
				
        // ]]>
        </script>');
        /* load RTE */
        $this->loadRichTextEditor();
	
	}//
	
	
// Get list of available translations for this resource
// -----------------------------------------------------------------------------------------------
private function getAvailableTranslationList(){
		global $modx;
		$query = $modx->newQuery('Translation');
		$query->where(array(
			'articleID' => $this->resource->get('id')
		));
		$translations = $modx->getCollection('Translation',$query);
		$list = array();
		foreach($translations as $T){
			$arr = $T->toArray();
			$list[] = "'".$arr['language']."'";
		};
		return implode(',',$list);
	}//
	
};// end class modTranslatedDocumentUpdateManagerController
