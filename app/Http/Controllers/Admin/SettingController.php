<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Setting.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $mail = MailSetting::get();
        return DataTables::of($mail)->addIndexColumn()->addColumn('action', function ($data) {
            return "<a href='#' data-id='$data->id' class='edit menu-icon tf-icons d-flex '><i class='bx bx-edit-alt'></i></a>";
        })->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mail = MailSetting::find($id);
        if (!$mail) {
            return response()->json(['error' => 'id tidak ditemukan']);
        }
        return response()->json(['success' => $mail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()]);
        }
        $mail = MailSetting::find($id);
        $mail->username = $request->username;
        $mail->email = $request->email;
        $mail->password = $request->password;
        $mail->save();

        return response()->json(['success' => 'success mengupdate email']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}