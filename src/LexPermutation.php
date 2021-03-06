<?php

namespace Core;

use Core\Permutation;

class LexPermutation implements Permutation
{
    /**
     * Get next permutation.
     * @param  array  $perm
     * @return array
     */
    public function successor(array $perm)
    {
        $n = count($perm);
        $perm = array_merge([0], $perm);
        $i = $n - 1;
        $j = $n;

        while($perm[$i] >= $perm[$i+1])
            $i--;
        
        if($i == 0)
            return null;

        while($perm[$i] > $perm[$j])
            $j--;

        // Sweetch
        $tmp = $perm[$i];
        $perm[$i] = $perm[$j];
        $perm[$j] = $tmp;

        // Combine two array
        $end_perm = array_slice($perm, $i+1, $n);
        asort($end_perm);
        $begin_perm = array_slice($perm, 1, $i);

        return array_merge($begin_perm, $end_perm); 
    }

    /**
     * Get previus permutation.
     * @param  array  $perm
     * @return array
     */
    public function predeccessor(array $perm)
    {
        $rank = $this->rank($perm) - 1;
        if($rank < 0) return null;
        return $this->unrank(count($perm), $rank);
    }

    /**
     * Find rank number of permutation.
     * @param  array  $perm
     * @return Integer
     */
    public function rank(array $perm)
    {
        $n = count($perm);

        if($n == 2) {
            $sorted = $perm;
            asort($sorted);
            return $sorted === $perm ? 0 : 1;
        }

        $tmp = array_slice($perm, 1);
        $tmp = array_map(function($a) use ($perm) {
            return $a > $perm[0] ? $a-1 : $a;
        }, $tmp);
        $tmp_rank = $this->rank($tmp);

        return ($perm[0] - 1) * $this->fact($n - 1) + $tmp_rank;
    }

    /**
     * Make permutation from rank number.
     * @param  int    $n    length
     * @param  int    $rank
     * @return array
     */
    public function unrank(int $n, int $rank)
    {
        if($rank > $this->fact($n) - 1 || $rank < 0 || $n < 0)
            return null;

        $perm = [];
        $a = [];

        for ($i = 0; $i < $n; $i++) { 
            $a[$i] = $i + 1;
        }

        for ($i = 0; $i < $n; $i++) {
            if(!$fact = $this->fact($n-$i-1)) {
                foreach($a as $key => $element) {
                    if($element) {
                        $perm[$i] = $element;
                    }
                }
            } else {
                $k = floor($rank / $fact);
                $rank = $rank % $fact;
                $j = 0;
                while ($k >= 0) {
                    if($a[$j] != 0) 
                        $k--;
                    $j++;
                }
                $perm[$i] = $a[$j-1];
                $a[$j-1] = 0;
            }
        }
        return $perm;
    }

    /**
     * Return factorial.
     * @param  int    $num
     * @return int
     */
    private function fact(int $num)
    {
        if(! $num) return 0;

        $factorial = 1;
        for ($x = $num; $x >= 1; $x--) {
          $factorial = $factorial * $x;
        }
        return $factorial;
    }
}