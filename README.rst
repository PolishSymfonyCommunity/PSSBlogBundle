PSSBlogBundle
========================

Symfony2 blog bundle is based on the WordPress database model.


Installation
========================

In order to install this bundle if you are using SE you should add the following to your deps.

You want to fork the central repository. Then do add the following:
    
[PSSBlogBundle]
    git=https://yourusernameongithub@github.com/yourusernameongithub/PSSBlogBundle.git
    target=/bundles/PSS/Bundle/BlogBundle

You should add the following dependencies to your deps file too:

[PaginatorBundle]
    git=git://github.com/KnpLabs/KnpPaginatorBundle.git
    target=/bundles/Knp/Bundle/PaginatorBundle
    version=v1.0

[Zend]
    git=git://github.com/zendframework/zf2.git
    target=/Zend

You should remember about ``bin/vendors install`` command

Configuration
========================

After download of needed bundles you should add some configuration.

You should register namespace in ``app/autoload.php``:

    $loader->registerNamespaces(array(
        ...
        'Knp\Bundle'       => __DIR__.'/../vendor/bundles',
        'Zend'             => __DIR__.'/../vendor/Zend/library',
        'PSS'              => __DIR__.'/../vendor/bundles/',
    ));

You should register bundles in ``app/AppKernel.php``:

    public function registerBundles()
    {
        $bundles = array(
            ...
            
            new PSS\Bundle\BlogBundle\PSSBlogBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        );
    }


