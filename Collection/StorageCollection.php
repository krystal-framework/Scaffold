<?php

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
