PSSBlogBundle
=============

Symfony2 blog bundle based on the WordPress database model.

[![Build Status](https://secure.travis-ci.org/PolishSymfonyCommunity/PSSBlogBundle.png?branch=master)](http://travis-ci.org/PolishSymfonyCommunity/PSSBlogBundle)

## Installation

### Add PSSBlogBundle to your composer.json

```js
{
    "require": {
        "polishsymfonycommunity/blog-bundle": "*"
    }
}
```

### Enable the bundle

Enable the PSSBlogBundle and the KnpPaginatorBundle bundles in the kernel (`app/AppKernel.php`):

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new PSS\Bundle\BlogBundle\PSSBlogBundle()
    );
}
```
