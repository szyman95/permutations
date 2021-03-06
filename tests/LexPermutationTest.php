<?php

namespace Tests;

use Core\LexPermutation;
use PHPUnit\Framework\TestCase;

class LexPermutationTest extends TestCase
{
    private $permutation;

    private $results = [
            [1,2,4,3],
            [1,3,2,4],
            [1,3,4,2],
            [1,4,2,3],
            [1,4,3,2],
            [2,1,3,4],
            [2,1,4,3],
            [2,3,1,4],
            [2,3,4,1],
            [2,4,1,3],
            [2,4,3,1],
            [3,1,2,4],
            [3,1,4,2],
            [3,2,1,4],
            [3,2,4,1],
            [3,4,1,2],
            [3,4,2,1],
            [4,1,2,3],
            [4,1,3,2],
            [4,2,1,3],
            [4,2,3,1],
            [4,3,1,2]
        ];

    public function setUp()
    {
        $this->permutation = new LexPermutation;
    }

    public function testSuccesor()
    {
        $perm = [1,2,3,4];

        // Check next permutations
        foreach ($this->results as $expect) {
            $perm = $this->permutation->successor($perm);
            $this->assertEquals($perm, $expect);
        }
    }

    public function testPredecessor()
    {
        $perm = [4,3,2,1];

        foreach (array_reverse($this->results) as $expect) {
            $perm = $this->permutation->predeccessor($perm);
            $this->assertEquals($perm, $expect);
        }
    }

    public function testRanAndUnrank()
    {
        for($len = 2; $len <= 8; $len++) {
            $rank = 0;
            while($perm = $this->permutation->unrank($len, $rank)) {
                $this->assertEquals($this->permutation->rank($perm), $rank);
                $rank++;
            }
        }
    }
}