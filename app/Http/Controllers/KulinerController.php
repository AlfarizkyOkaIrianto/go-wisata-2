<?php

namespace App\Http\Controllers;

use App\Models\DataPaketKuliner;
use App\Models\ReviewKuliner;
use App\Models\Detail_transaksi;
use Illuminate\Http\Request;
use App\Models\Kuliner;
use App\Models\tb_paketkuliner;
use App\Models\Tempat;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;


class KulinerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tempat  = Tempat::where('user_id', Auth::user()->petugas_id)->where('status', '1')->pluck('id')->first();

        $kuliner = Kuliner::where('tempat_id', $tempat)->get();
        $paketKuliner = DataPaketKuliner::where('tempat_id', $tempat)->get();
        $dataPaketKuliner = [];
        foreach ($paketKuliner as $data) {
            array_push($dataPaketKuliner, tb_paketkuliner::where('data_paket_kuliner_id', $data->id)->get());
        }

        // dd($dataPaketKuliner[0]);
        return view('kuliner.kuliner.index', compact('kuliner', 'paketKuliner', 'dataPaketKuliner'));
        // return view('kuliner.kuliner.index', compact('kuliner'));
    }

    public function editStatus(Request $request)
    {
        DataPaketKuliner::where('id', $request->id)->update(['status' => $request->status]);
        return redirect(route('kuliner.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Kuliner::max('kode_kuliner');

        $huruf = "K";
        $urutan = (int)substr($data, 2, 3);
        $urutan++;
        $makanan_id = $huruf . sprintf("%03s", $urutan);
        // dd($wahana_id);
        $tempat  = Tempat::where('user_id', Auth::user()->petugas_id)->where('status', '1')->get();
        // dd($tempat);
        return view('kuliner.kuliner.create', compact('makanan_id', 'tempat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validateStore($request);
        $data = $request->all();
        $name = (new Kuliner)->userAvatar($request);
        $data['image'] = $name;
        Kuliner::create($data);

        Toastr::success('Membuat akun admin berhasil :)', 'Success');

        return redirect()->route('kuliner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);

        $admin = Kuliner::where('id', $id)->first();
        $user = Kuliner::find($id);
        $data = $request->all();
        // if ($request->deskripsi == null) {
        //     data['name']=
        //     data['harga']=
        // }
        $imageName = $user->image;
        if ($request->hasFile('image')) {
            $imageName = (new Kuliner)->userAvatar($request);
            if ($admin->image == null) {
            } else {
                unlink(public_path('images/' . $user->image));
            }
        }
        $data['image'] = $imageName;
        // dd($data);
        $user->update($data);
        // Toastr::success('Messages in here', 'Title', ["positionClass" => "toast-top-center"]);
        Toastr::success(' Berhasil mengubah status :)', 'Success');
        return redirect()->route('wahana.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->id == $id) {
            abort(401);
        }

        $user = Kuliner::find($id);
        $userDelete = $user->delete();
        if ($userDelete) {
            unlink(public_path('images/' . $user->image));
        }
        Toastr::success('Data berhasil dihapus :)', 'Success');

        return redirect()->route('kuliner.index');
    }
    public function toggleStatus($id)
    {
        $sesii = Kuliner::find($id);
        $sesii->status = !$sesii->status;
        $sesii->save();
        Toastr::info('Data Updated :)', 'Success');
        return redirect()->back();
    }
    public function review_index()
    {
        $reviewk = ReviewKuliner::orderby('id', 'desc')->get();
        return view('admin.kuliner.halaman_nilai_kuliner', [
            'reviewk' => $reviewk
        ]);
    }
    public function review_delete($id)
    {
        $reviewk = ReviewKuliner::find($id);
        $reviewk->delete($reviewk);
        Toastr::success(' Berhasil menghapus data:)', 'Success');
        return redirect()->back();
    }
    //masuk ke web route (penilaian)
    public function rating($kode)
    {
        // return dd($kode);
        $kode = $kode;
        $data = Detail_transaksi::where('kode_tiket', $kode)->first();
        $reviewkuliner = ReviewKuliner::where('kode_tiket', $kode)->first();
        return view('rating.ratingkuliner', compact('data', 'reviewkuliner', 'kode'));

        // if ($reviewkuliner) {
        //     return view('rating.ratingkuliner', compact('reviewkuliner'));
        // }

        // return view('rating.input', compact('data'));
        // return view('rating.ratingkuliner', compact('data'));
    }

    public function tambah_rating(Request $request, $kode)
    {
        $reviewk = Detail_transaksi::where('kode_tiket', $kode)->first();
        // $reviewk->kuliner_id = $request->kuliner_id;
        // $reviewk->rating = $request->rating;
        // $reviewk->comment = $request->comment;
        // $reviewk->kode_tiket = $request->kode_tiket;
        // $reviewk->user_id = $request->user_id;
        // $reviewk->status = '1';
        // $reviewk->save();

        $rating = [
            'rating' => $request->rating,
            'comment' => $request->comment,
            'nama' => Auth::user()->name,
            'kuliner_id' => $reviewk->id_produk,
            'user_id' => Auth::user()->id,
            'status' => 1
        ];

        ReviewKuliner::where('kode_tiket', $kode)->update($rating);

        Toastr::success('Berhasil menambahkan ulasan :)', 'Success');
        return redirect('/pesananku');
    }
    public function put_rating(Request $request, $kode)
    {
        $reviewk = ReviewKuliner::where('kode_tiket', $kode)->first();
        $reviewk->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        if ($reviewk) {
            Toastr::success('Berhasil memperbarui ulasan :)', 'Success');
            return redirect()->back();
        } else {
            Toastr::success('Gagal memperbarui ulasan :(', 'Fail');
            return redirect()->back();
        }
    }
    public function Backuptambah_rating(Request $request, $id)
    {
        $reviewk = ReviewKuliner::find($id);
        $reviewk->penilaian = $request->penilaian;
        $reviewk->comment = $request->comment;
        $reviewk->kode_tiket = $request->kode_tiket;
        $reviewk->user_id = $request->user_id;
        $reviewk->status = '1';
        Toastr::success('Berhasil menambahkan ulasan :)', 'Success');
        $reviewk->save();
        return redirect('/pesananku');
    }
    public function delete_rating($id)
    {
        $rating = ReviewKuliner::find($id);
        $rating->delete($rating);
        Toastr::success('Berhasil menghapus ulasan :)', 'Success');
        return redirect()->back();
    }
    public function update_rating(Request $request, $id)
    {
        $reviewk = ReviewKuliner::find($id);
        $reviewk->rating = $request->rating;
        $reviewk->comment = $request->comment;
        $reviewk->save();
        Toastr::success('Berhasil update komentar :)', 'Success');
        return redirect()->back();
    }
}
