<?php
class TranslatedDocumentCreateManagerController extends ResourceCreateManagerController {

    public function getLanguageTopics() {
        return array('resource','translations:default');
    }
}
