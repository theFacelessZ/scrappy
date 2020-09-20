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
     * Converts the storage to array.
     *
     * @return array
     *   Array storage representation.
     */
    public function toArray();

}
