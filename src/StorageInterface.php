<?php

namespace Scrappy;

interface StorageInterface {

    /**
     * Returns storage field value.
     *
     * @param $field
     *   Target field.
     *
     * @return mixed
     *   Field value.
     */
    public function &get($field);

    /**
     * Returns true if a field is present, false otherwise.
     *
     * @param $field
     *   Target field.
     *
     * @return boolean
     *   True if the field exists.
     */
    public function has($field);

    /**
     * Returns a set of storage fields.
     *
     * @return string[]
     *   Keys array.
     */
    public function getKeys();

    /**
     * Converts the storage to array.
     *
     * @return array
     *   Array storage representation.
     */
    public function toArray();

    /**
     * Calculates delta data from the other storage.
     *
     * @param \Scrappy\StorageInterface $other
     *   The other storage.
     * @param callable $comparer
     *   Value comparer used for the delta.
     *
     * @return array
     *   Delta data.
     */
    public function delta(StorageInterface $other, callable $comparer = NULL);

}
