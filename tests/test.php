<?php

include '../vendor/autoload.php';

$scrappy = new \Scrappy\Scrappy();
$sources = 5000;

// Include random sources as a test.
for ($i = 0; $i < $sources; $i++) {
    $scrappy->addSource(
        new \ScrappyTest\Sources\RandomDelayedSource()
    );
}

/**
 * Measures execution time of a given callback.
 *
 * @param callable $callback
 *   A callback.
 *
 * @return float
 *   Measured time in seconds.
 */
function measure(callable $callback) {
    $time = microtime(true);
    $callback();
    $time = microtime(true) - $time;

    return $time;
}

echo "Executing default ::updateAll() procedure.\r\n";
$time = measure(function () use ($scrappy) {
    $scrappy->updateAll();
});

echo "Took: $time\r\n";

echo "Executing multiprocess ::updateAllThreaded().\r\n";
$time = measure(function () use ($scrappy) {
    $scrappy->updateAllThreaded();
});

echo "Took: $time\r\n";
