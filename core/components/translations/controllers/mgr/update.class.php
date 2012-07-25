<?php
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
class TranslatedDocumentUpdateManagerController extends ResourceUpdateManagerController {


public function getLanguageTopics() {
		return array('resource','translations:default','translations:languages');
	}//
	
	
//------------------------------------------------------------------------------------------------------------------------
public function loadCustomCssJs() {
        $managerUrl = $this->context->getOption('manager_url', MODX_MANAGER_URL, $this->modx->_userConfig);
		$jsUrl = $this->context->getOption('assets_url').'components/translations/js/';
		$cssUrl = $this->context->getOption('assets_url').'components/translations/css/';
		$connectorUrl = $this->context->getOption('assets_url').'components/translations/connector.php';
		
        $this->addJavascript($managerUrl.'assets/modext/util/datetime.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/element/modx.panel.tv.renders.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.grid.resource.security.local.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.panel.resource.tv.js');
        $this->addJavascript($managerUrl.'assets/modext/sections/resource/update.js');
        $this->addJavascript($managerUrl.'assets/modext/widgets/resource/modx.panel.resource.js');
       
        $this->addJavascript($jsUrl.'mgr/sections/resource/update.js');
        $this->addJavascript($jsUrl.'mgr/widgets/modx.panel.resource.translations.js');
        $this->addJavascript($jsUrl.'mgr/widgets/modx.panel.resource.translations.tabs.js');
 	    $this->addJavascript($jsUrl.'mgr/widgets/modx.panel.resource.js');
 	    $this->addJavascript($jsUrl.'mgr/widgets/modx.combo.languages.js');
 	    $this->addJavascript($jsUrl.'mgr/widgets/modx.window.newtranslation.js');
        $this->addCss($cssUrl.'translations.css');


		$this->addHtml('
        <script type="text/javascript">
        // <![CDATA[
        MODx.config.publish_document = "'.$this->canPublish.'";
        MODx.onDocFormRender = "'.$this->onDocFormRender.'";
        MODx.ctx = "'.$this->resource->get('context_key').'";
        Ext.onReady(function() {
            MODx.load({
                xtype: "modx-page-translatedresource-update"
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
            Ext.create({
            	xtype: \'modx-window-newtranslation\'
            });
        });
		TranslatedArticleLanguages = "'.$this->getAllLanguages().'".split(",");
		
		AvailableTranslations = Array('.$this->getAvailableTranslationList().');
		
		TranslationsJSON = '.$this->resource->getTranslationsJSON().';
		
		TranslationsConnector = "'.$connectorUrl.'";
				
        // ]]>
        </script>');
        /* load RTE */
        $this->loadRichTextEditor();
	
	}//
	
	
	
 /**
     * Initialize a RichText Editor, if set
     *
     * @return void
     */
    public function loadRichTextEditor() {
        /* register JS scripts */
        $rte = isset($this->scriptProperties['which_editor']) ? $this->scriptProperties['which_editor'] : $this->context->getOption('which_editor', '', $this->modx->_userConfig);
        $this->setPlaceholder('which_editor',$rte);
        /* Set which RTE if not core */
        if ($this->context->getOption('use_editor', false, $this->modx->_userConfig) && !empty($rte)) {
            /* invoke OnRichTextEditorRegister event */
            $textEditors = $this->modx->invokeEvent('OnRichTextEditorRegister');
            $this->setPlaceholder('text_editors',$textEditors);

            $this->rteFields = array('ta','ta-fr','ta-de');
            $this->setPlaceholder('replace_richtexteditor',$this->rteFields);

            /* invoke OnRichTextEditorInit event */
            $resourceId = $this->resource->get('id');
            $onRichTextEditorInit = $this->modx->invokeEvent('OnRichTextEditorInit',array(
                'editor' => $rte,
                'elements' => $this->rteFields,
                'id' => $resourceId,
                'resource' => &$this->resource,
                'mode' => !empty($resourceId) ? modSystemEvent::MODE_UPD : modSystemEvent::MODE_NEW,
            ));
            if (is_array($onRichTextEditorInit)) {
                $onRichTextEditorInit = implode('',$onRichTextEditorInit);
                $this->setPlaceholder('onRichTextEditorInit',$onRichTextEditorInit);
            }
        }
    }
	
	
	
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
	
	
public function getAllLanguages(){

	

	return $this->context->getOption('translations.languages');

	}//
	
};// end class modTranslatedDocumentUpdateManagerController
