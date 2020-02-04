## About Shopware Ide Helper
Generates `phpstorm.meta.php` file for your IDE.

Tested with Shopware 5.6

## Install

**The Terminal Way**
```
cd custom/plugins
git clone https://github.com/pictus/SoupIdeHelper.git SoupIdeHelper
cd ../../
php bin/console sw:plugin:refresh
php bin/console sw:plugin:install SoupIdeHelper --activate --clear-cache
```
**The Other Way**

clone repository to `custom/plugins` directory, call the directory `SoupIdeHelper`
install in shopware

## Run
run `php bin/console  soup:idehelper:build` from your shopware root.