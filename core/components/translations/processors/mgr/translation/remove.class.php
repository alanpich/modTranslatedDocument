<?php
class TranslationsTranslationRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'Translation';
    public $languageTopics = array('translations:default');
    public $objectType = 'translations.translation';
}
return 'TranslationsTranslationRemoveProcessor';
