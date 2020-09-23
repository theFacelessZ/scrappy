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

    /**
     * Handles sources in multiprocess fashion.
     *
     * @param bool $wait
     *   When set true will wait for the subprocesses to be closed.
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function updateAllThreaded($wait = true) {
        $forks = new \SplStack();

        foreach ($this->sources as $source) {
            // Create a process for each source, which in theory
            // can introduce an increase in performance.
            $pid = pcntl_fork();

            switch ($pid) {
                case -1:
                    throw new \Exception('Failed to fork the root process.');

                    break;

                case 0:
                    // Perform the actual work on a forked process.
                    $source->fetch();
                    if ($source->isUpdated()) {
                        $this->handleUpdate($source);
                    }

                    die(1);

                default:
                    // TODO: Implement poolsize restriction to prevent dozens
                    //  of subprocesses from being spawned.
                    $forks->push($pid);

                    break;
            }
        }

        // Wait for the forks to stop.
        if ($wait) {
            $forks->rewind();
            while (!$forks->isEmpty()) {
                $status = 0;
                pcntl_waitpid($forks->pop(), $status);
            }
        }

        return $this;
    }

}
