<?php

namespace Scrappy;

abstract class StorageBase implements StorageInterface {

    /**
     * {@inheritDoc}
     */
    public function delta(StorageInterface $other, callable $comparer = NULL)
    {
        $keys = $other->getKeys();
        $delta = [];

        // Initialise default comparer if a custom one is not
        // provided by a caller.
        if (!$comparer) {
            $comparer = function ($a, $b) {
                // Treat arrays differently.
                if (is_array($a) && is_array($b)) {
                    $diff_removed = array_diff($a, $b);
                    $diff_added = array_diff($b, $a);

                    return !empty($diff_removed) || !empty($diff_added);
                }

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
