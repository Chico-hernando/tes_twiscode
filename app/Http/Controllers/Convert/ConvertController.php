<?php

namespace App\Http\Controllers\Convert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConvertController extends Controller
{

    public function convert(Request $request)
    {
        if ($request->convert == "binToDec"){

            $digit = str_split($request->data);
            $reverse = array_reverse($digit);
            $data = 0;

            for($i=0; $i < count($reverse); $i++) {
                if($reverse[$i] == 1) {
                    $data += pow(2, $i);
                }
            }

        }elseif ($request->convert == "decToBin"){

            $number = $request->data;

            $binary ='';
            while ($number>=1){
                $bin = $number % 2;
                $number = round($number/2, 0, 2);
                $binary .= $bin;
            }
            $data = strrev($binary);

        } else{
            return $this->responseError("Wrong Command","");
        }

        return $this->responseSuccess("Succesfully Convert", $data);
    }

}
