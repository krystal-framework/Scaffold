<?php

namespace Scaffold\Collection;

use Krystal\Stdlib\ArrayCollection;

final class StorageCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    protected $collection = [
        'MySQL' => 'MySQL',
        'mSQL' => 'mSQL',
        'PostgreSQL' => 'PostgreSQL',
        'Redis' => 'Redis',
        'Memcached' => 'Memcached',
        'Memory' => 'Memory'
    ];
}
