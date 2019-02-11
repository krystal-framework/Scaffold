<?php

/**
 * This file is part of the Krystal Framework
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Scaffold\Collection;

use Krystal\Stdlib\ArrayCollection;

final class StorageCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    protected $collection = [
        'MySQL',
        'mSQL',
        'PostgreSQL',
        'Redis',
        'Memcached',
        'Memory'
    ];
}
