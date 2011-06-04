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
            $steps->Given(sprintf('the blog post "%s" is tagged with "%s" keywords', $row['title'], $row['tags']), $world);
        }

        if (isset($row['categories'])) {
            $steps->Given(sprintf('the blog post "%s" belongs to "%s" categories', $row['title'], $row['categories']), $world);
        }
    }
});

$steps->Given('/^the blog post "(.*?)" is tagged with "(.*?)" keywords$/', function ($world, $postTitle, $tags) use ($steps) {
    $tags = explode(',', trim($tags));

    if (!empty($tags)) {
        foreach ($tags as $tagName) {
            $steps->Given(sprintf('the blog post "%s" is tagged with "%s" keyword', $postTitle, $tagName), $world);
        }
    }
});

$steps->Given('/^the blog post "(.*?)" belongs to "(.*?)" categories$/', function ($world, $postTitle, $categories) use ($steps) {
    $categories = explode(',', trim($categories));

    if (!empty($categories)) {
        foreach ($categories as $categoryName) {
            $steps->Given(sprintf('the blog post "%s" belongs to "%s" category', $postTitle, $categoryName), $world);
        }
    }
});

$steps->Given('/^the blog post "(.*?)" is tagged with "(.*?)" keyword$/', function ($world, $postTitle, $tagName) use ($steps) {
    $steps->Given(sprintf('the blog post "%s" is labeled with "%s" post_tag', $postTitle, $tagName), $world);
});

$steps->Given('/^the blog post "(.*?)" belongs to "(.*?)" category$/', function ($world, $postTitle, $categoryName) use ($steps) {
    $steps->Given(sprintf('the blog post "%s" is labeled with "%s" category', $postTitle, $categoryName), $world);
});

$steps->Given('/^the blog post "(.*?)" is labeled with "(.*?)" (.*?)$/', function ($world, $postTitle, $termName, $taxonomyName) use ($steps) {
    $steps->Given(sprintf('site has "%s" term which is a "%s" taxonomy', $termName, $taxonomyName), $world);

    $taxonomy = $world->taxonomies[$taxonomyName][$termName];
    $post = $world->posts[$postTitle];
    $relation = new PSS\Bundle\BlogBundle\Entity\TermRelationship();
    $postCount = getPrivateProperty($taxonomy, 'count');

    setPrivateProperty($relation, 'post', $post);
    setPrivateProperty($relation, 'objectId', getPrivateProperty($post, 'id'));
    setPrivateProperty($relation, 'termTaxonomy', $taxonomy);
    setPrivateProperty($relation, 'termTaxonomyId', getPrivateProperty($taxonomy, 'id'));
    setPrivateProperty($relation, 'termOrder', '1');

    if ('publish' == getPrivateProperty($post, 'status')) {
        setPrivateProperty($taxonomy, 'count', ++$postCount);
    }

    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');
    $entityManager->persist($taxonomy);
    $entityManager->persist($relation);
    $entityManager->flush();
});


$steps->Given('/^site has tags:$/', function ($world, $table) use ($steps) {
    foreach ($table->getHash() as $row) {
        $steps->Given(sprintf('site has "%s" tag', $row['tag']), $world);
    }
});

$steps->Given('/^site has categories:$/', function ($world, $table) use ($steps) {
    foreach ($table->getHash() as $row) {
        $steps->Given(sprintf('site has "%s" category', $row['tag']), $world);
    }
});

$steps->Given('/^site has "(.*?)" tag$/', function ($world, $tagName) use ($steps) {
    $steps->Given(sprintf('site has "%s" term which is a "post_tag" taxonomy', $tagName), $world);
});

$steps->Given('/^site has "(.*?)" category$/', function ($world, $tagName) use ($steps) {
    $steps->Given(sprintf('site has "%s" term which is a "category" taxonomy', $tagName), $world);
});

$steps->Given('/^site has "(.*?)" term which is a "(.*?)" taxonomy$/', function ($world, $termName, $taxonomyName) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

    if (!isset($world->terms[$termName])) {
        $term = new PSS\Bundle\BlogBundle\Entity\Term();

        setPrivateProperty($term, 'name', $termName);
        setPrivateProperty($term, 'slug', $termName);
        setPrivateProperty($term, 'group', 0);

        $entityManager->persist($term);

        $world->terms[$termName] = $term;
    }

    if (!isset($world->taxonomies[$taxonomyName][$termName])) {
        $term = $world->terms[$termName];
        $taxonomy = new PSS\Bundle\BlogBundle\Entity\TermTaxonomy();

        setPrivateProperty($taxonomy, 'taxonomy', $taxonomyName);
        setPrivateProperty($taxonomy, 'description', '');
        setPrivateProperty($taxonomy, 'parentId', 0);
        setPrivateProperty($taxonomy, 'count', 0);
        setPrivateProperty($taxonomy, 'term', $term);

        $entityManager->persist($taxonomy);

        $world->taxonomies[$taxonomyName][$termName] = $taxonomy;
    }

    $entityManager->flush();
});
