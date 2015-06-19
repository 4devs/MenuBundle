Getting Started With MenuBundle
===========================================

## Installation and usage

Installation and usage is a quick:

1. Download MenuBundle using composer
2. Enable the Bundle
3. Use the bundle


### Step 1: Download MenuBundle using composer

Tell composer to download the bundle by running the command:

``` bash
$ php composer.phar require fdevs/menu-bundle
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FDevs\LocaleBundle\FDevsLocaleBundle(),
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        
        new FDevs\MenuBundle\FDevsMenuBundle(),
    );
}
```
and add config

``` yml
f_devs_menu:
    admin_service: 'sonata'
    
sonata_admin:
    extensions:
        f_devs_menu.admin_extension.menu_node_referrers:
            implements:
                - FDevs\MenuBundle\Model\MenuReferrersInterface
```


### Step 3: Use the bundle

add menu your page model

```php
<?php

namespace AppBundle\Document;

use FDevs\MenuBundle\Model\MenuReferrersInterface;
use FDevs\MenuBundle\Model\MenuReferrersTrait;

class Page extends BasePage implements MenuReferrersInterface
{
    use MenuReferrersTrait;
}
```

add doctrine mapping

```xml
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mongo-mapping xmlns="http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping
                        http://doctrine-project.org/schemas/odm/doctrine-mongo-mapping.xsd">

    <mapped-superclass name="AppBundle\Document\Page">
        <reference-many target-document="FDevs\MenuBundle\Model\Menu" field="menuList" fieldName="menuList"/>
    </mapped-superclass>

</doctrine-mongo-mapping>
```

create menu `navbar` in database and show in twig

```twig
{{ knp_menu_render('navbar',{'depth':1,'currentAsLink': false, 'compressed':true}) }}
```