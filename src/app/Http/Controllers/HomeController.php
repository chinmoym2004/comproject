<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function downloadFile($id){
        $id = decrypt($id);
        $file = Upload::find($id);

        if(!$file)
            abort(404);

        return response()->download(storage_path('public/'.$file->file_loc),$file->file_name);
    }
}
