<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function createTransaksi(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tanggal_order' => 'required',
            'status' => 'required',
        ]);


        if ($validate->fails()) {
            return $this->responseError("Data not valid", $validate->errors()->first());
        }

        $req = $request->all();
        $transaksi = new Transaksi();

        foreach ($req as $key => $values) {
            $transaksi[$key] = $values;
        }

        if ($transaksi->save()) {
            $data = Transaksi::where('id', $transaksi['id'])->get();
            return $this->responseSuccess('Success create data', $data);
        } else {
            return $this->responseError('Failed create data', 'Failed create data');
        }
    }

    public function getTransaksi(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
        if ($request->status == "lunas"){
            $data = Transaksi::where('status','lunas')
                ->join('transaksi_detail as td','td.id_transaksi','=','transaksi.id')
                ->selectRaw('transaksi.*,SUM(td.subtotal) AS total,SUM(td.jumlah) AS jumlah_barang')
                ->groupBy('transaksi.id')->get();

        } elseif ($request->status == "pending"){
            $data = Transaksi::where('status','pending')
                ->join('transaksi_detail as td','td.id_transaksi','=','transaksi.id')
                ->selectRaw('transaksi.*,SUM(td.subtotal) AS total,SUM(td.jumlah) AS jumlah_barang')
                ->groupBy('transaksi.id')->get();

        }else{
        $data = Transaksi::join('transaksi_detail as td','td.id_transaksi','=','transaksi.id')
            ->selectRaw('transaksi.*,SUM(td.subtotal) AS total,SUM(td.jumlah) AS jumlah_barang')
            ->groupBy('transaksi.id')
            ->get();
        }

        if (!$data) {
            return $this->responseError("Failed get data", "Something went wrong");
        }
        return $this->responseSuccess("Succesfully get data", $data);
    }

    public function updateTransaksi(Request $request,$id)
    {
        $validate = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->responseError("Data not valid", $validate->errors()->first());
        }

        $update = Transaksi::where('id', $id)->update([
            'status' => $request->status,
            'tanggal_pembayaran' => now()
        ]);
        if ($update) {
            $data = Transaksi::where('id', $id)->get();
            return $this->responseSuccess('Success update transaksi', $data);
        } else {
            return $this->responseError('Failed update Attendance', 'Nothing to update');
        }
    }

    public function deleteTransaksi($id)
    {

        $delete = Transaksi::where('id', $id)->delete();


        if ($delete) {
            return $this->responseSuccess("Success delete transaksi", "");
        } else {
            return $this->responseError("Failed delete transaksi", "");
        }
    }
}
