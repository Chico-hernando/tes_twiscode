<?php

namespace App\Http\Controllers\TransaksiDetail;

use App\Http\Controllers\Controller;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiDetailController extends Controller
{
    public function getTransaksiDetail($id)
    {

        $data = TransaksiDetail::where('id_transaksi',$id)->get();

        if (!$data) {
            return $this->responseError("Failed get data", "Something went wrong");
        }
        return $this->responseSuccess("Succesfully get data", $data);
    }

    public function creataTransaksiDetail(Request $request,$id)
    {
        $validate = Validator::make($request->all(), [
            'harga' => 'required',
            'jumlah' => 'required',
        ]);


        if ($validate->fails()) {
            return $this->responseError("Data not valid", $validate->errors()->first());
        }

        $req = $request->all();
        $transaksiDetail = new TransaksiDetail();

        foreach ($req as $key => $values) {
            $transaksiDetail[$key] = $values;
        }

        $transaksiDetail['id_transaksi'] = $id;
        $transaksiDetail['subtotal'] = $request->harga*$request->jumlah;

        if ($transaksiDetail->save()) {
            $data = TransaksiDetail::where('id', $transaksiDetail['id'])->get();
            return $this->responseSuccess('Success create data', $data);
        } else {
            return $this->responseError('Failed create data', 'Failed create data');
        }
    }

    public function updateTransaksiDetail(Request $request,$id,$idDetail)
    {
        $validate = Validator::make($request->all(), [
            'jumlah' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->responseError("Data not valid", $validate->errors()->first());
        }

        $harga = TransaksiDetail::where('id',$idDetail)->first()->harga;


        $update = TransaksiDetail::where('id', $idDetail)->update([
            'jumlah' => $request->jumlah,
            'subtotal' => (int) $request->jumlah*$harga
        ]);
        if ($update) {
            $data = TransaksiDetail::where('id', $idDetail)->get();
            return $this->responseSuccess('Success update transaksiDetail', $data);
        } else {
            return $this->responseError('Failed update Attendance', 'Nothing to update');
        }
    }

    public function deleteTransaksiDetail($id,$idDetail)
    {
        $delete = TransaksiDetail::where('id', $idDetail)->delete();
        if ($delete) {
            return $this->responseSuccess("Success delete transaksiDetail", "");
        } else {
            return $this->responseError("Failed delete transaksiDetail", "");
        }
    }

}
