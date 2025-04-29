<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $stations = Station::with(['country', 'city', 'language'])->paginate(10);

        return view('stations.index', compact('stations'));


    }

    public function search(){

    }
}
