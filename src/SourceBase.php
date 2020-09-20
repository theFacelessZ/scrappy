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
     * Extracts target storage value.
     *
     * @param StorageInterface $storage
     *   Target storage.
     * @param array $parts
     *   Field parts.
     *
     * @return mixed|StorageInterface
     *   Storage value.
     *
     * @throws \Exception
     */
    protected function &extractStorageValue(StorageInterface &$storage, array $parts = []) {
        $value = &$storage;

        foreach ($parts as $part) {
            if ($value instanceof StorageInterface) {
                if (!$value->has($part)) {
                    throw new \Exception('Missing storage field.');
                }

                $value = &$value->get($part);
            }
            elseif (is_array($value)) {
                $value = &$value[$part];
            }
            else {
                $value = &$value->{$part};
            }
        }

        return $value;
    }

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
        foreach ($this->getLookupFields() as $field) {
            $parts = explode('::', $field);
            unset($this->delta[$field]);

            try {
                $valueOld = $this->extractStorageValue($this->storageOutdated, $parts);
                $valueNew = $this->extractStorageValue($this->storageCurrent, $parts);

                $updated = $valueNew != $valueOld;

                // Store the delta.
                if ($updated) {
                    $this->delta[$field] = [$valueOld, $valueNew];
                }
            }
            catch (\Exception $exception) {
                // Treat the model as updated model on any exception.
                $updated = true;
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
        $storageOld = $this->storageCurrent;
        $this->storageCurrent = $this->doFetch();
        $this->storageOutdated = $storageOld;

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
    public function getDelta(): array
    {
        return $this->delta;
    }

}
