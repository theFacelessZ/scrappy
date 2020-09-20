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

}
