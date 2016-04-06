<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function inventoryFilePage(){
        return view('whInterface.inventoryFilePage');
    }

    public function productInfoPage(){
        return view('whInterface.productInfoPage');
    }

    public function shipmentStatusPage(){
        return view('whInterface.shipmentStatusPage');
    }
}
