<?php
class TranslationsTranslationCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'Translation';
    public $languageTopics = array('translations:default');
    public $objectType = 'translations.translation';
}
return 'TranslationsTranslationCreateProcessor';
