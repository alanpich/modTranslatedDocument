--------------------
Extra: Translations
--------------------
Version: 1.0 beta
 
Allows for easy translation management of resources.

See https://github.com/alanpich/modTranslatedDocument/ for full details

====================
 INSTALLATION GUIDE
====================

1) Install package (will complete, but show error creating DB model)

2) Install package again (this time db table will create succesfully?!?!?!?!?!)

3) Attach OnHandleRequest event to plugin Translations/TranslationGateway

4) Create a 'Translated Document' as you would a normal resource. Save

5) Once the page has refreshed, switch to the 'Translations' tab and select 'New Translation'

6) Pick your language from the dropdown (This lists all languages currently in the lexicon)

7) Add your content to the translation fields

6) Visit the page in your browser. 

NOTE: 	Language Switching is set by your browser's request language. 
		It can be overridden by explicitely setting the GET param language
		(i.e http://www.example.com/?id=123&language=fr)
		
If a translation does not exist in the requested language, the main resource language will be used
