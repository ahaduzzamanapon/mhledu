<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class LandingController extends Controller
{

    public function __construct()
	{
        //dd('hello_con');
        $this->middleware('PM');
        // User::checkAuth();
	}
    public function landing()
    {


        try {
            return view('frontEnd.landing.index');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function index()
    {
        dd('hello');
       
        try {
            return view('frontEnd.landing.index');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
