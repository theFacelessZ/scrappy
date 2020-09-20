<?php

namespace ScrappyTest\UpdateHandlers;

use Scrappy\SourceInterface;
use Scrappy\UpdateHandlerBase;

class EchoHandler extends UpdateHandlerBase {

    public function handle(SourceInterface $source)
    {
        $type = get_class($source);
        $storage = json_encode($source->getStorage()->toArray());

        echo "Detected an update for model $type.";
        echo "Contents: $storage";
        echo "\r\n";
    }

}
