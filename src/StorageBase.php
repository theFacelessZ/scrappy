<?php

namespace Scrappy;

abstract class StorageBase implements StorageInterface {

    /**
     * {@inheritDoc}
     */
    public function delta(StorageInterface $other, callable $comparer = NULL) {
        $keys = $other->getKeys();
        $delta = [];

        // Initialise default comparer if a custom one is not
        // provided by a caller.
        if (!$comparer) {
            $comparer = function ($a, $b) {
                return $a != $b;
            };
        }

        foreach ($keys as $key) {
            $value_this = $this->get($key);
            $value_other = $other->get($key);

            if ($comparer($value_this, $value_other)) {
                $delta[$key] = [$value_other, $value_this];
            }
        }

        return $delta;
    }

}
