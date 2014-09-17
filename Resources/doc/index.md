Getting Started With MenuBundle
===========================================

## Installation and usage

Installation and usage is a quick:

1. Download MenuBundle using composer
2. Enable the Bundle
3. Use the bundle


### Step 1: Download MenuBundle using composer

Add MenuBundle in your composer.json:

```js
{
    "require": {
        "fdevs/menu-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fdevs/menu-bundle
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FDevs\MenuBundle\FDevsMenuBundle(),
    );
}
```
and add config

``` yml
f_devs_menu:
    admin_service: 'sonata'
```


### Step 3: Use the bundle
