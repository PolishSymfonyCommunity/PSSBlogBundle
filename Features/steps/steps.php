<?php

// We don't want to add setters just because we need them in tests.
// Also, we want to set raw data. This copies the way Doctrine's loading
// fixtures.
function setPrivateProperty ($object, $propertyName, $value) {
    $reflection = new ReflectionObject($object);
    $property = $reflection->getProperty($propertyName);
    $property->setAccessible(true);
    $property->setValue($object, $value);
};

function getPrivateProperty ($object, $propertyName) {
    $reflection = new ReflectionObject($object);
    $property = $reflection->getProperty($propertyName);
    $property->setAccessible(true);

    return $property->getValue($object);
};

$steps->Given('/^site has users:$/', function ($world, $table) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

    foreach ($table->getHash() as $row) {
        $user = new PSS\Bundle\BlogBundle\Entity\User();

        setPrivateProperty($user, 'login', $row['login']);
        setPrivateProperty($user, 'password', $row['password']);
        setPrivateProperty($user, 'niceName', $row['login']);
        setPrivateProperty($user, 'email', $row['email']);
        setPrivateProperty($user, 'url', $row['url']);
        setPrivateProperty($user, 'registeredAt', new DateTime('now'));
        setPrivateProperty($user, 'activationKey', 'key121212');
        setPrivateProperty($user, 'status', 0);
        setPrivateProperty($user, 'displayName', $row['display_name']);

        $entityManager->persist($user);

        $world->users[$row['login']] = $user;
    }

    $entityManager->flush();
});

$steps->Given('/^site has blog posts:$/', function ($world, $table) use ($steps) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

    foreach ($table->getHash() as $row) {
        $post = new PSS\Bundle\BlogBundle\Entity\Post();
        $user = $world->users[$row['user_login']];

        setPrivateProperty($post, 'title', $row['title']);
        setPrivateProperty($post, 'slug', $row['slug']);
        setPrivateProperty($post, 'type', $row['type']);
        setPrivateProperty($post, 'status', $row['status']);
        setPrivateProperty($post, 'publishedAt', new DateTime($row['published_at']));
        setPrivateProperty($post, 'publishedAtAsGmt', new DateTime($row['published_at']));
        setPrivateProperty($post, 'modifiedAt', new DateTime($row['published_at']));
        setPrivateProperty($post, 'modifiedAtAsGmt', new DateTime($row['published_at']));
        setPrivateProperty($post, 'excerpt', $row['excerpt']);
        setPrivateProperty($post, 'content', $row['content']);
        setPrivateProperty($post, 'author', $user);
        setPrivateProperty($post, 'commentStatus', '');
        setPrivateProperty($post, 'pingStatus', '');
        setPrivateProperty($post, 'password', '');
        setPrivateProperty($post, 'toPing', '');
        setPrivateProperty($post, 'pinged', '');
        setPrivateProperty($post, 'contentFiltered', '');
        setPrivateProperty($post, 'parentId', 0);
        setPrivateProperty($post, 'guid', '');
        setPrivateProperty($post, 'menuOrder', '');
        setPrivateProperty($post, 'mimeType', '');
        setPrivateProperty($post, 'commentCount', '');

        $entityManager->persist($post);
        $entityManager->flush();

        $world->posts[$row['title']] = $post;

        if (isset($row['tags'])) {
            $steps->Given(sprintf('the blog post "%s" is tagged with keywords:', $row['title']), $world, $row['tags']);
        }
    }
});

$steps->Given('/^the blog post "(.*?)" is tagged with keywords:$/', function ($world, $postTitle, $tags) use ($steps) {
    $tags = explode(',', trim($tags));

    if (!empty($tags)) {
        foreach ($tags as $tagName) {
            $steps->Given(sprintf('the blog post "%s" is tagged with "%s" keyword', $postTitle, $tagName), $world);
        }
    }
});

$steps->Given('/^the blog post "(.*?)" is tagged with "(.*?)" keyword$/', function ($world, $postTitle, $tagName) use ($steps) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

    $steps->Given(sprintf('the site has "%s" tag', $tagName), $world);

    $tag = $world->tags[$tagName];
    $taxonomy = $world->taxonomies[$tagName];
    $post = $world->posts[$postTitle];
    $relation = new PSS\Bundle\BlogBundle\Entity\TermRelationship();

    setPrivateProperty($relation, 'post', $post);
    setPrivateProperty($relation, 'objectId', getPrivateProperty($post, 'id'));
    setPrivateProperty($relation, 'termTaxonomy', $taxonomy);
    setPrivateProperty($relation, 'termTaxonomyId', getPrivateProperty($taxonomy, 'id'));
    setPrivateProperty($relation, 'termOrder', '1');

    $entityManager->persist($relation);
    $entityManager->flush();
});

$steps->Given('/^the site has "(.*?)" tag$/', function ($world, $tagName) {
    if (!isset($world->tags[$tagName])) {
        $container = $world->getKernel()->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $tag = new PSS\Bundle\BlogBundle\Entity\Term();
        $taxonomy = new PSS\Bundle\BlogBundle\Entity\TermTaxonomy();

        setPrivateProperty($taxonomy, 'taxonomy', 'post_tag');
        setPrivateProperty($taxonomy, 'description', '');
        setPrivateProperty($taxonomy, 'parentId', '0');
        setPrivateProperty($taxonomy, 'count', '1');
        setPrivateProperty($taxonomy, 'term', $tag);
        setPrivateProperty($tag, 'name', $tagName);
        setPrivateProperty($tag, 'slug', $tagName);
        setPrivateProperty($tag, 'group', 0);

        $entityManager->persist($tag);
        $entityManager->persist($taxonomy);
        $entityManager->flush();

        $world->tags[$tagName] = $tag;
        $world->taxonomies[$tagName] = $taxonomy;
    }
});

