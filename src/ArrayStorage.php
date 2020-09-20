<?php

namespace Scrappy;

class ArrayStorage implements StorageInterface {

    /**
     * Array storage.
     *
     * @var array
     */
    protected $storage;

    /**
     * ArrayStorage constructor.
     *
     * @param array $storage
     *   Storage source.
     */
    public function __construct(array $storage)
    {
        $this->storage = $storage;
    }

    /**
     * {@inheritDoc}
     */
    public function &get($field)
    {
        return $this->storage[$field];
    }

    /**
     * {@inheritDoc}
     */
    public function has($field)
    {
        return isset($this->storage[$field]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->storage;
    }

}
