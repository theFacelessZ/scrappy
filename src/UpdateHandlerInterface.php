<?php

namespace Scrappy;

interface UpdateHandlerInterface {

    /**
     * Handles a source update.
     *
     * @param SourceInterface $source
     *   An updated source.
     *
     * @return mixed
     */
    public function handle(SourceInterface $source);

    /**
     * Returns true if the handler can be applied to a specific source.
     *
     * @param SourceInterface $source
     *   Target source.
     *
     * @return boolean
     *   True if the handler can be applied.
     */
    public function appliesTo(SourceInterface $source);

}
