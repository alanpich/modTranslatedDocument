--------------------
Extra: Translations
--------------------
Version: 1.0 beta2
 
Allows for easy translation management of resources.

See https://github.com/alanpich/modTranslatedDocument/ for full details

====================
 INSTALLATION GUIDE
====================

1) Install package via the package manager

2) Create a 'Translated Document' as you would a normal resource. Save

3) Once the page has refreshed, switch to the 'Translations' tab and select 'New Translation'

4) Pick your language from the dropdown (This lists all languages currently in the lexicon)

5) Add your content to the translation fields

6) Visit the page in your browser. 

NOTE: 	Language Switching is set by your browser's request language. 
		It can be overridden by explicitely setting the GET param language
		(i.e http://www.example.com/?id=123&language=fr)
		
If a translation does not exist in the requested language, the main resource language will be used
