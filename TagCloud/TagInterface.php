<?php

/*
 * This file is part of the PSSBlogBundle package.
 *
 * (c) Jakub Zalas <jakub@zalas.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PSS\Bundle\BlogBundle\TagCloud;

/**
 * This interface should be implemented by every tag class used with TagCloud.
 *
 * @author Jakub Zalas <jakub@zalas.pl>
 */
interface TagInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return integer
     */
    public function getFrequency();
}

