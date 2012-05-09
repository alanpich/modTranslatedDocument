#modTranslatedDocument
##A translatable resource type for Modx Revolution 2.2+

modTranslatedDocument aims to be a full alternative to the native Document resource class in Modx. 
Documents using this class can offer translations of all text-based resource properties based on the 
cultureKey of the context in which they are requested.

**This Extra is currently in a beta phase, and as such may behave unexpectedly.**

* Download the beta transport package [here](https://github.com/alanpich/modTranslatedDocument/downloads)
* [Installation Guide](#installation-guide)

###Why a custom resource?
After looking into the best solution for a multi-lingual microsite build in ModX, [Babel](https://github.com/mikrobi/babel/)
seemed to be the only pre-packaged extra that was considered. A very robust package without doubt, but the idea of separating 
each translation of what, generally, is the same information into separate resources 
and contexts didn't sit right with me.

Why should what is, delivery language aside, supposedly the same information be split accross several nodes on what could be 
a rather large tree. An article exists to serve a piece of information or point of view to the world. If it is the same point 
of view or piece of information, it is (in the web's terms) the same resource, irregardless of the language it is delivered in.

As a result, this project aims to deliver a solution that will allow a resource to be translated into as many languages as 
are required while still maintaining a semantic resource tree.

##The Requirements

1. **Transparent delivery of correct language** 
  * *[[*pagetitle]] should return a page title in the appropriate language, without additional snippet-ing.* 
2. **3rd-party extras such as [getResources](http://rtfm.modx.com/display/ADDON/getResources) should work transparently.**
3. **Resource caching should not be compromised**
4. **Translation management interfaces should feel native to the resource**

## Components
* **modTranslatedDocument** custom resource class
* **TranslationsGateway** plugin to assign correct cultureKey based on browser language and/or saved preference cookie

## Installation Guide
1. Install package (will complete, but show error creating DB model)
2. Install package again (this time db table will create succesfully?!?!?!?!?!)
3. Attach *OnHandleRequest* event to plugin *Translations/TranslationGateway*
4. Create a 'Translated Document' as you would a normal resource. Save
5. Once the page has refreshed, switch to the *Translations* tab and select *New Translation*
6. Pick your language from the dropdown (This lists all languages currently in the lexicon)
7. Add your content to the translation fields
6. Visit the page in your browser. 

**NOTE:**  Language Switching is set by your browser's request language. 
		It can be overridden by explicitely setting the GET param *language*
		(i.e http://www.example.com/?id=123&language=fr)
		
If a translation does not exist in the requested language, the main resource language will be used

