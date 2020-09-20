<?php

namespace Scrappy;

abstract class UpdateHandlerBase implements UpdateHandlerInterface {

    /**
     * A set of target classes the handler applies to.
     * Leave it empty to allow the handler to be applied
     * to any kind of source.
     *
     * @var array
     */
    protected $appliesTo = [];

    /**
     * {@inheritDoc}
     */
    public function appliesTo(SourceInterface $source)
    {
        if (empty($this->appliesTo)) {
            return true;
        }

        return in_array(
            get_class($source),
            $this->appliesTo
        );
    }

}
