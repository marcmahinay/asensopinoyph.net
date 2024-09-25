<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function qrScanner()
    {
        return view('qr.qr-scanner');
    }

    public function verify(Request $request)
    {

    }
}
