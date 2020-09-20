<?php

namespace ScrappyTest\UpdateHandlers;

use Scrappy\SourceInterface;
use Scrappy\UpdateHandlerBase;

class EchoHandler extends UpdateHandlerBase {

    public function handle(SourceInterface $source)
    {
        $type = get_class($source);
        $storage = json_encode($source->getStorage()->toArray());
        $delta = json_encode($source->getDelta());

        echo "Detected an update for model $type.\r\n";
        echo "Contents: $storage\r\n";
        echo "Delta: $delta\r\n";
    }

}
