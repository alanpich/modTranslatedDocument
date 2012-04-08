<?php class modTranslatedDocumentUpdateProcessor extends modResourceUpdateProcessor {

/**
     * Do any processing before the save of the Resource but after fields are set.
     * @return boolean
     */
    public function beforeSave() {
        $beforeSave = parent::beforeSave();
        
        // Get all translated data as arrays
        $translations = $this->getTranslatedFields();
           
        foreach($translations as $lang => $fields){
        	$row = $this->modx->getObject('Translation',$fields['id']);
        	$row->set('pagetitle',$fields['pagetitle']);
        	$row->set('longtitle',$fields['longtitle']);
        	$row->set('menutitle',$fields['menutitle']);
        	$row->set('introtext',$fields['introtext']);
        	$row->set('description',$fields['description']);
        	$row->set('content',$fields['content']);
        	$row->save();
        };
       
        return $beforeSave;
    }


/**
 * Gather translated fields as array
 * @return array
 */
private function getTranslatedFields() {
        $langs = explode(',',$_REQUEST['translations']);
		$translations = array();
		foreach($langs as $lang){		
			$translations[$lang] = array(
				'id' => (int) $_REQUEST['TranslationID'.$lang],
				'pagetitle' => $_REQUEST['pagetitle'.$lang],
				'longtitle' => $_REQUEST['longtitle'.$lang],
				'menutitle' => $_REQUEST['menutitle'.$lang],
				'introtext' => $_REQUEST['introtext'.$lang],
				'description' => $_REQUEST['description'.$lang],
				'content' => $_REQUEST['content'.$lang],
			);					
		};
		return $translations;		
	}//


    /**
     * Do any custom after save processing
     * @return boolean
     */
    public function afterSave() {
        $afterSave = parent::afterSave();
        $this->modx->log(modX::LOG_LEVEL_DEBUG,'Saving a Copyrighted Page!');
        return $afterSave;
    }

};// end class TranslatedDocumentUpdateProcessor
