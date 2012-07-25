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

/**
 * Grabs a list of lexicon languages
 *
 * @param integer $start (optional) The record to start at. Defaults to 0.
 * @param integer $limit (optional) The number of records to limit to. Defaults
 * to 10.
 *
 * @package modx
 * @subpackage processors.system.language
 */
class TranslationsLanguagesGetListProcessor extends modProcessor {
    public function checkPermissions() {
        return $this->modx->hasPermission('languages');
    }
    public function getLanguageTopics() {
        return array('lexicon');
    }
    public function initialize() {
        $this->setDefaultProperties(array(
            'start' => 0,
            'limit' => 10,
            'namespace' => 'core',
        ));
        return true;
    }
    public function process() {
    	global $modx;
        $data = $this->getData();
        if (empty($data)) return $this->failure();
        
        $modx->lexicon->load('translations:languages');
        
        /* loop through */
        $list = array();
        foreach ($data['results'] as $language) {
            $list[] = array(
                'name' => $modx->lexicon('translations.language.'.$language),
                'code' => $language
            );
        }

        return $this->outputArray($list,$data['total']);
    }

    /**
     * Get a collection of languages
     * @return array
     */
    public function getData() {
        $data = array();

        $limit = $this->getProperty('limit',10);
        $isLimit = !empty($limit);

        $data['results'] = $this->modx->lexicon->getLanguageList($this->getProperty('namespace'));
        $data['total'] = count($data['results']);

        if ($isLimit) {
            $data['results'] = array_slice($data['results'],$this->getProperty('start'),$limit,true);
        }
        return $data;
    }
}
return 'TranslationsLanguagesGetListProcessor';
