<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function showAsset(Request $request) {
        return view('');
    }
    public function updateAsset(Request $request) {
        return $request;
    }
}
