<?php

namespace Scrappy;

interface SourceInterface {

    /**
     * Signifies the source update state.
     *
     * @return boolean
     *   True if updated.
     */
    public function isUpdated();

    /**
     * Updates the source storage.
     *
     * @return $this
     */
    public function fetch();

    /**
     * Returns current source storage.
     *
     * @return StorageInterface
     *   The storage.
     */
    public function getStorage(): StorageInterface;

    /**
     * Updates current storage.
     *
     * @param \Scrappy\StorageInterface $storage
     *   Updated storage.
     *
     * @return $this
     */
    public function updateStorage(StorageInterface $storage);

    /**
     * Returns delta value set.
     *
     * @return array
     *   A set of previous and current changed values.
     */
    public function getDelta(): array;

}
