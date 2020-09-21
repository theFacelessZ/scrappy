<?php

namespace Scrappy;

abstract class SourceBase implements SourceInterface {

    /**
     * Source update flag.
     *
     * @var boolean|null
     */
    protected $isUpdated;

    /**
     * Previous version storage.
     *
     * @var StorageInterface
     */
    protected $storageOutdated;

    /**
     * Current version interface.
     *
     * @var StorageInterface
     */
    protected $storageCurrent;

    /**
     * A set of delta values.
     *
     * @var array
     */
    protected $delta = [];

    /**
     * Returns a list of the fields to look up to upon determining the update state.
     *
     * @return string[]
     *   A set of target fields to check against the outdated version.
     */
    abstract protected function getLookupFields();

    /**
     * {@inheritDoc}
     */
    public function isUpdated()
    {
        if (isset($this->isUpdated)) {
            return $this->isUpdated;
        }

        $updated = false;

        // If there is nothing to compare, treat the source as
        // updated.
        if (!$this->storageOutdated instanceof StorageInterface) {
            return $this->isUpdated = true;
        }

        // Compare the two storage values.
        // If at least one value is updated, treat the source
        // to be an updated source.
        $this->delta = $this->storageCurrent->delta($this->storageOutdated);
        foreach ($this->getLookupFields() as $field) {
            $updated = isset($this->delta[$field]);

            if ($updated) {
                break;
            }
        }

        return $this->isUpdated = $updated;
    }

    /**
     * Perform the fetch procedure itself.
     *
     * @return StorageInterface
     *   Fetching result as a storage.
     */
    abstract protected function doFetch(): StorageInterface;

    /**
     * {@inheritDoc}
     */
    public function fetch()
    {
        $this->updateStorage(
            $this->doFetch()
        );

        // Make sure the update flag is invalidated.
        $this->isUpdated = null;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getStorage(): StorageInterface
    {
        return $this->storageCurrent;
    }

    /**
     * {@inheritDoc}
     */
    public function updateStorage(StorageInterface $storage)
    {
        // Set the new storage swapping the current one.
        $storageOld = $this->storageCurrent;
        $this->storageCurrent = $storage;
        $this->storageOutdated = $storageOld;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDelta(): array
    {
        return $this->delta;
    }

}
