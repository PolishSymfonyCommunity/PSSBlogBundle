<?php

// We don't want to add setters just because we need them in tests.
// Also, we want to set raw data. This copies the way Doctrine's loading
// fixtures.
function setPrivateProperty($propertyName, $value, $reflection, $object) {
    $property = $reflection->getProperty($propertyName);
    $property->setAccessible(true);
    $property->setValue($object, $value);
};

function getPrivateProperty($propertyName, $reflection, $object) {
    $property = $reflection->getProperty($propertyName);
    $property->setAccessible(true);

    return $property->getValue($object);
};

$steps->Given('/^site has users:$/', function ($world, $table) {
    $container = $world->getKernel()->getContainer();
    $entityManager = $container->get('doctrine.orm.entity_manager');

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
        $entityManager->flush();

        $tags = array();
        if (isset($row['tags'])) {
            $tags = explode(',', trim($row['tags']));
        }
        if (!isset($world->tags)) {
            $world->tags = array();
        }
        if ($tags) {
            foreach ($tags as $tagName) {
                if (!isset($world->tags[$tagName])) {
                    $tag = new PSS\Bundle\BlogBundle\Entity\Term();
                    $taxonomy = new PSS\Bundle\BlogBundle\Entity\TermTaxonomy();
                    $tagReflection = new ReflectionObject($tag);
                    $taxonomyReflection = new ReflectionObject($taxonomy);

                    $setTagPrivateProperty = function($propertyName, $value) use ($tagReflection, $tag) {
                        setPrivateProperty($propertyName, $value, $tagReflection, $tag);
                    };

                    $setTaxonomyPrivateProperty = function($propertyName, $value) use ($taxonomyReflection, $taxonomy) {
                        setPrivateProperty($propertyName, $value, $taxonomyReflection, $taxonomy);
                    };

                    $setTaxonomyPrivateProperty('taxonomy', 'post_tag');
                    $setTaxonomyPrivateProperty('description', '');
                    $setTaxonomyPrivateProperty('parentId', '0');
                    $setTaxonomyPrivateProperty('count', '1');
                    $setTagPrivateProperty('name', $tagName);
                    $setTagPrivateProperty('slug', $tagName);
                    $setTagPrivateProperty('group', 0);
                    $entityManager->persist($tag);

                    $setTaxonomyPrivateProperty('term', $tag);

                    $entityManager->persist($taxonomy);
                    $entityManager->flush();

                    $getTaxonomyPrivateProperty = function($propertyName) use ($taxonomyReflection, $taxonomy) {
                        return getPrivateProperty($propertyName, $taxonomyReflection, $taxonomy);
                    };

                    $world->tags[$tagName] = $tag;
                } else {
                  $tag = $world->tags[$tagName];
                  $tagReflection = new ReflectionObject($tag);
                  $getTagPrivateProperty = function($propertyName) use ($tagReflection, $tag) {
                      return getPrivateProperty($propertyName, $tagReflection, $tag);
                  };

                  $taxonomy = $entityManager->createQuery(
                      'SELECT t FROM PSS\Bundle\BlogBundle\Entity\TermTaxonomy t
                      WHERE t.termId = :termId'
                  )->setParameter('termId', $getTagPrivateProperty('id'))->getSingleResult();

                  $taxonomyReflection = new ReflectionObject($taxonomy);
                  $getTaxonomyPrivateProperty = function($propertyName) use ($taxonomyReflection, $taxonomy) {
                      return getPrivateProperty($propertyName, $taxonomyReflection, $taxonomy);
                  };
                }

                $getPostPrivateProperty = function($propertyName) use ($postReflection, $post) {
                    return getPrivateProperty($propertyName, $postReflection, $post);
                };

                $relation = new PSS\Bundle\BlogBundle\Entity\TermRelationship();
                $relationReflection = new ReflectionObject($relation);
                $setRelationPrivateProperty = function($propertyName, $value) use ($relationReflection, $relation) {
                    setPrivateProperty($propertyName, $value, $relationReflection, $relation);
                };

                try {
                    $entityManager->createQuery(
                        'SELECT r FROM PSS\Bundle\BlogBundle\Entity\TermRelationship r
                        WHERE r.objectId = :objectId AND r.termTaxonomyId = :termTaxonomyId'
                    )
                    ->setParameter('objectId', $getPostPrivateProperty('id'))
                    ->setParameter('termTaxonomyId', $getTaxonomyPrivateProperty('id'))
                    ->getSingleResult();
                } catch (Doctrine\ORM\NoResultException $e) {
                    $setRelationPrivateProperty('post', $post);
                    $setRelationPrivateProperty('objectId', $getPostPrivateProperty('id'));
                    $setRelationPrivateProperty('termTaxonomy', $taxonomy);
                    $setRelationPrivateProperty('termTaxonomyId', $getTaxonomyPrivateProperty('id'));
                    $setRelationPrivateProperty('termOrder', '1');
                    $entityManager->persist($relation);
                    $entityManager->flush();
                }
            }
        }
    }

    $entityManager->flush();
});

