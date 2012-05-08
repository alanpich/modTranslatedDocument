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
        	if(	$row = $this->modx->getObject('Translation',$lang)){
				$row->set('pagetitle',$fields['pagetitle']);
				$row->set('longtitle',$fields['longtitle']);
				$row->set('menutitle',$fields['menutitle']);
				$row->set('introtext',$fields['introtext']);
				$row->set('description',$fields['description']);
				$row->set('content',$fields['content']);
		    	$row->save();
        	};
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
			foreach($translations[$lang] as $key => $val){
				if($translations[$lang][$key] == null){
				 $translations[$lang][$key] = '';
				};
			};	
		};
		return $translations;		
	}//


/**
 * Cleanup the processor and return the resulting object
 *		-> Remove the translated fields from response
 *
 * @return array
 */
    public function cleanup() {
        $this->object->removeLock();
        $this->clearCache();

        $returnArray = $this->object->get(array_diff(array_keys($this->object->_fields), array('content','ta','introtext','description','link_attributes','pagetitle','longtitle','menutitle','properties')));
        foreach ($returnArray as $k => $v) {
            if (strpos($k,'tv') === 0) {
                unset($returnArray[$k]);
            }
        }
		
		// Remove translations fields
		$translations = $this->getTranslatedFields();
		foreach($translations as $lang => $fields){
			foreach($fields as $key => $val){
				if(isset($returnArray[$key.$lang])){
					unset($returnArray[$key.$lang]);
				};
			};
		};
		
		$this->modx->log(1,print_r($returnArray,true));

		
        $returnArray['class_key'] = $this->object->get('class_key');
        $this->workingContext->prepare(true);
        $returnArray['preview_url'] = $this->modx->makeUrl($this->object->get('id'), $this->object->get('context_key'), '', 'full');
        return $this->success('',$returnArray);
    }


};// end class TranslatedDocumentUpdateProcessor
