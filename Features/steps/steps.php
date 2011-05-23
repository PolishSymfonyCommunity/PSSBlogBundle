<?php

// We don't want to add setters just because we need them in tests.
// Also, we want to set raw data. This copies the way Doctrine's loading
// fixtures.
function setPrivateProperty($propertyName, $value, $reflection, $object) {
    $property = $reflection->getProperty($propertyName);
    $property->setAccessible(true);
    $property->setValue($object, $value);
};

$steps->Given('/^site has users:$/', function ($world, $table) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

    $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\User')->execute();

    if (!isset($world->users)) {
        $world->users = array();
    }

    foreach ($table->getHash() as $row) {
        $user = new PSS\Bundle\BlogBundle\Entity\User();

        $userReflection = new ReflectionObject($user);

        $setUserPrivateProperty = function($propertyName, $value) use ($userReflection, $user) {
            setPrivateProperty($propertyName, $value, $userReflection, $user);
        };

        $setUserPrivateProperty('login', $row['login']);
        $setUserPrivateProperty('password', $row['password']);
        $setUserPrivateProperty('niceName', $row['login']);
        $setUserPrivateProperty('email', $row['email']);
        $setUserPrivateProperty('url', $row['url']);
        $setUserPrivateProperty('registeredAt', new DateTime('now'));
        $setUserPrivateProperty('activationKey', 'key121212');
        $setUserPrivateProperty('status', 0);
        $setUserPrivateProperty('displayName', $row['display_name']);

        $entityManager->persist($user);

        $world->users[$row['login']] = $user;
    }

    $entityManager->flush();
});

$steps->Given('/^site has blog posts:$/', function($world, $table) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

    $entityManager->createQuery('DELETE PSS\Bundle\BlogBundle\Entity\Post')->execute();

    foreach ($table->getHash() as $row) {
        $post = new PSS\Bundle\BlogBundle\Entity\Post();
        $user = $world->users[$row['user_login']];

        $postReflection = new ReflectionObject($post);

        $setPostPrivateProperty = function($propertyName, $value) use ($postReflection, $post) {
            setPrivateProperty($propertyName, $value, $postReflection, $post);
        };

        $setPostPrivateProperty('title', $row['title']);
        $setPostPrivateProperty('slug', $row['slug']);
        $setPostPrivateProperty('type', $row['type']);
        $setPostPrivateProperty('status', $row['status']);
        $setPostPrivateProperty('publishedAt', new DateTime($row['published_at']));
        $setPostPrivateProperty('publishedAtAsGmt', new DateTime($row['published_at']));
        $setPostPrivateProperty('modifiedAt', new DateTime($row['published_at']));
        $setPostPrivateProperty('modifiedAtAsGmt', new DateTime($row['published_at']));
        $setPostPrivateProperty('excerpt', $row['excerpt']);
        $setPostPrivateProperty('content', $row['content']);
        $setPostPrivateProperty('author', $user);
        $setPostPrivateProperty('category', '');
        $setPostPrivateProperty('commentStatus', '');
        $setPostPrivateProperty('pingStatus', '');
        $setPostPrivateProperty('password', '');
        $setPostPrivateProperty('toPing', '');
        $setPostPrivateProperty('pinged', '');
        $setPostPrivateProperty('contentFiltered', '');
        $setPostPrivateProperty('parentId', 0);
        $setPostPrivateProperty('guid', '');
        $setPostPrivateProperty('menuOrder', '');
        $setPostPrivateProperty('mimeType', '');
        $setPostPrivateProperty('commentCount', '');

        $entityManager->persist($post);
    }

    $entityManager->flush();
});

