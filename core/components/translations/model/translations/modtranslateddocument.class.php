<?php
class modTranslatedDocument extends modResource {

public $showInContextMenu = true;

function __construct(xPDO & $xpdo) {
        parent :: __construct($xpdo);
        $this->set('class_key','modTranslatedDocument');
		
		$language = $xpdo->getOption('cultureKey');
		$this->language = $language;
		$this->_cacheKey = '[contextKey]/resources/'.$language.'/[id]';
		
		$this->_pagetitle = "arse";
				
    }
	
// Return the path to controllers --------------------------------------------------------------------------------------------------------------------
public static function getControllerPath(xPDO &$modx) {
		return $modx->getOption('core_path').'components/translations/controllers/mgr/';
	}//
	

// Return text to use in manager context create menus ------------------------------------------------------------------------------------------------
public function getContextMenuText() {
		$this->xpdo->lexicon->load('translations:default');
		return array(
			'text_create' => $this->xpdo->lexicon('translations.document'),
			'text_create_here' => $this->xpdo->lexicon('translations.createDocumentHere'),
		);
	}//	


// Return the name of this resource type --------------------------------------------------------------------------------------------------------------
public function getResourceTypeName() {
		$this->xpdo->lexicon->load('translations:default');
		return $this->xpdo->lexicon('translations.document');
	}//
	
	
// Return the content for this article -----------------------------------------------------------------------------------------------------------------
public function getContent(array $options = array()) {
		$content = parent::getContent($options);
		$language = $this->getLanguage();
		$year = date('Y');
		
		if(!$content = $this->lookForTranslations('content')){
			$content = parent::getContent($options);
		};
		
		return $content;
	}//
	
	
// Process a resource, transforming source content to output. -------------------------------------------------------------------------------------------
 public function process(){ 
		switch($this->getLanguage()){
		//	case 'fr'	: $this->pagetitle = 'La title francais!';
		};
	
		return parent::process();
}//


// Override get for translations -----------------------------------
 public function get( $key ){
	 $orig = parent::get($key);
	 
	 $translated = array('pagetitle','longtitle','description','introtext','menutitle','content');
	 
	 if(in_array($key,$translated)){
		 $value = $this->lookForTranslations($key);  
		 if(!$value){$value = parent::get($key);};
	 } else {
	  	$value = parent::get($key);
	 };
	 
	 return $value;
 }//
	
	
	
	
    /**
     * Use this in your extended Resource class to modify the tree node contents
     * @param array $node
     * @return array
     */
    public function prepareTreeNode(array $node = array()) {
        return $node;
    }

//=======================================================================================================================================================
//=======================================================================================================================================================
	
private function lookForTranslations($field){
		global $modx;
		
		$query = $modx->newQuery('Translation');
		$query->where(array(
			'articleID' => $this->get('id'),
			'language' => $this->language
		));
		$translations = $modx->getCollection('Translation',$query);
		$value = '';
		
		foreach($translations as $T){
			$row = $T->toArray();
			return $row[$field];
		};
		return false;

	}//


private function getLanguage(){
		global $modx;
		return $modx->getOption('cultureKey');
	}//


};// end class modTranslatedDocument
