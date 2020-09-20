<?php

include '../vendor/autoload.php';

$scrappy = new \Scrappy\Scrappy();

// Include random sources as a test.
$scrappy->addSource(new \ScrappyTest\Sources\RandomSource());
$scrappy->addSource(new \ScrappyTest\Sources\RandomSource());
$scrappy->addSource(new \ScrappyTest\Sources\RandomSource());

$scrappy->addHandler(new \ScrappyTest\UpdateHandlers\EchoHandler());

for ($i = 0; $i < 10; $i++) {
    $scrappy->updateAll();
    sleep(5);
}
