<?php

namespace App\Http\Controllers;

use App\Jobs\StatusApplyJob;
use App\Mail\StatusApply;
use App\Models\ApplyJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ApplyJob::with('user', 'lowongan')->get();
        return view('Admin.Apply.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Create.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'job_id' => 'required',
            'cv' => 'required|mimes:pdf',
            'start' => 'required',
            'end' => 'required',
            'alamat' => 'required',
            'pendidikan' => 'required',
            'sekolah' => 'required',
            'portofolio_url' => 'required',
            'ig_url' => 'required',
            'gender' => 'required',
            'alasan' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $user = ApplyJob::where('id', Auth::user()->id)->where('konfirmasi', 'belum')->first();
        if ($user) {
            return redirect()->back()->withErrors(['sudah-Apply' => 'Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami']);
        }
        $apply = ApplyJob::create([
            'user_id' => auth()->id,
            'job_id' => $request->job_id,
            'cv' => $request->cv,
            'start' => $request->start,
            'end' => $request->end,
            'alamat' => $request->alamat,
            'pendidikan' => $request->pendidikan,
            'sekolah' => $request->sekolah,
            'portofolio_url' => $request->portofolio_url,
            'ig_url' => $request->ig_url,
            'gender' => $request->gender,
            'alasan' => $request->alasan,
        ]);

        if ($apply) {
            return redirect()->back()->with(['success' => 'Berhasil Apply']);
        } else {
            return redirect()->back()->with(['gagal' => 'Gagal Apply, Silahkan Apply Ulang']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apply =  ApplyJob::find($id);
        return view('Admin.Apply.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reject($id)
    {
        $apply = ApplyJob::find($id);
        $apply->konfirmasi = 'tidak-lulus';
        $apply->save();
        StatusApplyJob::dispatch($apply);
        return redirect()->back()->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }
    public function konfirm($id)
    {
        $apply = ApplyJob::find($id);
        $apply->konfirmasi = 'lulus';
        $apply->save();
        StatusApplyJob::dispatch($apply);
        return redirect()->back()->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
