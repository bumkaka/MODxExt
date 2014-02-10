MODx Evolution Extention pack
=========
##About
Created by Bumkaka from modx.im.
MODx Ext is a just another way to build projects on CMS MODx EVO with use libraries and packages not included in CMS. 

Base pack include :
```
-Idiorm/paris
-models 
   WebUsers
   ManagerUsers
   Content
```   

##Geting started
To start include string in your project.
```
require '/assets/ext/start.php';
```



##USE
- - -
ORM idiorm:
```
$content = ORM::for_table('modx_site_content')->find_one(5);
```

Models:
```
$Managers = ManagerUsers::find_many();
$Managers = ManagerUsers::get(5);
$Managers = ManagerUsers::current();
$Managers = ManagerUsers::active();
```
------------------


#Work
-----
##Add packs
copy pack to `assets/ext/vendor/`
>   **NOTE**:  FOLDER_NAME == CLASS_NAME == CLASS_FILE
>   **NOTE**:  namespace must repeat the path folders from start `/assets/ext/vendor/`

And this is all of you need :) .


####If class name different with folder name you make some variants:

a) create file in assets/ext/fasades/YOUR_CLASS_NAME.php with code like:
```
require EXT_BASE.'/vendor/YOUR_FOLDER_NAME/YOUR_CLASS.php';
```
b) add classname and path in assets/ext/config/app.php
c) add folder name in `assets/ext/config/path.php` if __CLASS_NAME == CLASS_NAME_FILE__
