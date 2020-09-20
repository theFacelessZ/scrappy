<?php

namespace ScrappyTest\Sources;

use Scrappy\ArrayStorage;
use Scrappy\SourceBase;
use Scrappy\StorageInterface;

class RandomSource extends SourceBase {

    /**
     * {@inheritDoc}
     */
    protected function getLookupFields()
    {
        return ['value'];
    }

    /**
     * {@inheritDoc}
     */
    protected function doFetch(): StorageInterface
    {
        return new ArrayStorage([
            'value' => random_int(0, 1000),
        ]);
    }

}
