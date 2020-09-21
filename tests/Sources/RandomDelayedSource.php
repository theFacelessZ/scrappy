<?php

namespace ScrappyTest\Sources;

use Scrappy\StorageInterface;

class RandomDelayedSource extends RandomSource {

    /**
     * {@inheritDoc}
     */
    protected function doFetch(): StorageInterface
    {
        // Introduce a random delay here.
        usleep(
            random_int(100, 10000)
        );

        return parent::doFetch();
    }

}
