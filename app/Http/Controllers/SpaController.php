<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class SpaController extends Controller
{
    public function index()
    {
        return view('index');
    }


}
