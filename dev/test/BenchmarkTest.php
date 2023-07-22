<?php

namespace PageMakerDev\Test;

use PageMakerDev\Benchmark;
use PHPUnit\Framework\TestCase;

class BenchmarkTest extends TestCase
{
    public function testBenchmarkMemory()
    {
        $benchmark = new Benchmark();

        $benchmark->start();

        $array = []; // Declare an array to allocate some memory
        for ($i = 0; $i < 100; $i++) {
            $array[] = $i;
        }

        $benchmark->end();

        // Ensure memory usage is greater than 0 since we allocated memory for an array
        $this->assertGreaterThan(0, $benchmark->getMemoryUsage());
    }

    public function testBenchmarkTime()
    {
        $benchmark = new Benchmark();

        usleep(100);  // sleep for 0.0001 seconds

        $benchmark->start();

        usleep(200);  // sleep for 0.0002 seconds

        $benchmark->end();

        // Since we've slept for 0.0002 seconds, the time should be close to this.
        $this->assertGreaterThanOrEqual(0.000, $benchmark->getTime());
        $this->assertLessThanOrEqual(0.001, $benchmark->getTime());
    }

    public function testPeakMemoryUsage()
    {
        $benchmark = new Benchmark();

        // Ensure the peak memory usage function works and returns a value greater than or equal to 0
        $this->assertGreaterThanOrEqual(0, $benchmark->getPeakMemoryUsage());
    }
}
