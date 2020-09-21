<?php

namespace Scrappy;

class Scrappy {

    /**
     * A set of scrappy sources.
     *
     * @var SourceInterface[]
     */
    protected $sources = [];

    /**
     * A set of update handlers.
     *
     * @var UpdateHandlerInterface[]
     */
    protected $handlers = [];

    /**
     * Appends a source to the service.
     *
     * @param SourceInterface $source
     *   A source to be added.
     *
     * @return $this
     */
    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;

        return $this;
    }

    /**
     * Appends a source update handler to the service.
     *
     * @param UpdateHandlerInterface $handler
     *   A source update handler.
     *
     * @return $this
     */
    public function addHandler(UpdateHandlerInterface $handler)
    {
        $this->handlers[] = $handler;

        return $this;
    }

    /**
     * Handles a source update.
     *
     * @param SourceInterface $source
     *   An updated source.
     */
    protected function handleUpdate(SourceInterface $source)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->appliesTo($source)) {
                $handler->handle($source);
            }
        }
    }

    /**
     * Updates all sources.
     *
     * @return $this
     */
    public function updateAll()
    {
        $iterator = $this->update();

        while ($iterator->current()) {
            $iterator->next();
        }

        return $this;
    }

    /**
     * Performs sources update procedure.
     *
     * @return \Generator
     *   Update items generator.
     */
    public function update()
    {
        foreach ($this->sources as $source) {
            $source->fetch();

            if ($source->isUpdated()) {
                $this->handleUpdate($source);
                yield $source;
            }
        }
    }

}
