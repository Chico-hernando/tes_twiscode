<?php

namespace App\Http\Controllers\Palindrome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PalindromeController extends Controller
{
    public function palindrome(Request $request)
    {
        $data = $this->longestPalindrome($request->data);

        if (!$data) {
            return $this->responseError("Failed find palindrome", "");
        }
        return $this->responseSuccess("Found Palindrome", $data);
    }

    function longestPalindrome($s) {

        if (strlen($s) == 0) {
            return "";
        }

        $start = $end = 0;

        for ($i = 0; $i < strlen($s); $i++) {
            $length1 = $this->findLengthLongestInPlace($s, $i, $i);
            $length2 = $this->findLengthLongestInPlace($s, $i, $i + 1);

            $maxLength = max($length1, $length2);

            if ($maxLength > $end - $start + 1) {
                $start = $i - intval(($maxLength - 1)/2);
                $end = $i + intval(($maxLength)/2);
            }
        }

        return substr($s, $start, $end - $start + 1);
    }

    private function findLengthLongestInPlace(string $s, int $left, int $right): int {
        $l = $left;
        $r = $right;

        while ($r < strlen($s) && $l > -1 && $s[$l] == $s[$r]) {
            $r++;
            $l--;
        }

        return $r - $l - 1;
    }
}
