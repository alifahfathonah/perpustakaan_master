<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home | Beranda'
        ];
        return view('buku.index', compact('data'));
    }

    public function buku()
    {
        $data_buku = Buku::all()->sortBy('tgl_terbit');
        $data = [
            'no' => '1',
            'title' => 'Data Buku'
        ];
        return view('buku.buku', compact('data_buku', 'data'));
    }

    public function store(Request $request) 
    {
        $buku = new Buku;
        
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'harga' => 'required',
            'tgl' => 'required'
        ]);
        
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl;
        $buku->save();
        return redirect('/buku')->with('status', 'Buku berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $buku = new Buku;
        $buku->find($id)->delete();
        return redirect('/buku')->with('delete', 'Data berhasil dihapus!');
    }

    public function update(Request $request, $id) 
    {
        $buku = Buku::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl;
        $buku->update();
        return redirect('/buku')->with('update', 'Buku berhasil diubah!');
    }
    public function search(Request $request) {
        $buku = $request->key;
        $data = [
            'no' => '1',
            'title' => 'search'
        ];
        $data_buku = Buku::where('judul', 'like', '%'.$buku.'%')->get();

        return view('buku.buku', compact('data_buku', 'data'));
    }
}
