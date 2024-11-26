<?php

namespace App\Http\Controllers;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = new Pelanggan();
        $data_pelanggan = $pelanggan->paginate(10);


        $id_pelanggan = $pelanggan->all()->last();
        $id = $id_pelanggan->id_pelanggan;
        $no = substr($id, 2);
        $no = intval($no) + 1;
        switch (true) {
            case $no < 10:
                $no = "P-00" . $no;
                break;
            case $no < 100:
                $no = "P-0" . $no;
                break;
            default:
                $no = "P-" . $no;
                break;
        }

        return view('pelanggan', [
            'pelanggan' => $data_pelanggan,
            'id_pelanggan' => $no
        ]);
    }

    public function simpanP(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        $pelanggan = new Pelanggan();
        if ($pelanggan->create($request->all())) {
            return redirect('/pelanggan')->with('success', 'Data pelanggan berhasil disimpan');
        }
        return back()->with('pesan', 'Gagal menyimpan data pelanggan');
    }
    public function edit($id_pelanggan)
    {
        $pelanggan = new Pelanggan();

        $edit_pelanggan = $pelanggan->find($id_pelanggan);
        $data_pelanggan = $pelanggan->paginate(10);
        return view('pelanggan', [
            'pelanggan' => $data_pelanggan,
            'edit' => $edit_pelanggan,
        ]);
    }
}
