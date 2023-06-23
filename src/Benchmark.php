<?php

namespace PageMaker;

/**
 * @class A basic PHP Benchmark class using the built-in microtime and memory usage functions to calculate the
 * execution time and memory usage.
 *
 * This class provides a way to start and end the benchmark, as well as get the time and memory usage between the start
 * and end times. You can use this class to benchmark any PHP script or block of code by creating an instance of the
 * class, calling the start method before the code to benchmark, and calling the end method after the code to benchmark.
 * Then you can get the execution time and memory usage using the getTime and getMemoryUsage methods respectively.
 *
 * Please remember that the memory_get_usage() function reports the amount of memory, in bytes, that's currently being
 * allocated to your PHP script, and memory_get_peak_usage() reports the peak memory amount that has been allocated to
 * your PHP script up until the point that the function is called.
 * Example usage:
 *
 * $benchmark = new Benchmark();
 * $benchmark->start();
 *
 * // Some code here...
 *
 * $benchmark->end();
 *
 * echo 'Execution time: ', $benchmark->getTime(), ' seconds', PHP_EOL;
 * echo 'Memory usage: ', $benchmark->getMemoryUsage(), ' bytes', PHP_EOL;
 * echo 'Peak memory usage: ', $benchmark->getPeakMemoryUsage(), ' bytes', PHP_EOL;
 */
class Benchmark
{
    private float $startTime;
    private float $endTime;
    private int $startMemory;
    private int $endMemory;

    public function start(): void
    {
        $this->startTime = microtime(true);
        $this->startMemory = memory_get_usage();
    }

    public function end(): void
    {
        $this->endTime = microtime(true);
        $this->endMemory = memory_get_usage();
    }

    public function getTime(): float
    {
        return round($this->endTime - $this->startTime, 3);
    }

    public function getMemoryUsage(): int
    {
        return $this->endMemory - $this->startMemory;
    }

    public function getPeakMemoryUsage(): int
    {
        return memory_get_peak_usage();
    }
}
