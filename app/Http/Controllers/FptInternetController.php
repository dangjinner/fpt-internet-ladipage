<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFptInternetRequest;
use App\Jobs\RegisterFptInternet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class FptInternetController
{
    public function index()
    {
        return view('index');
    }

    public function registerService(RegisterFptInternetRequest $request)
    {
        $data = array_merge($request->all(), [
            'ip' => $request->getClientIp(),
            'from_page' => $request->headers->get('referer'),
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        RegisterFptInternet::dispatch($data);
    }

    public function thankYou()
    {
        return view('thank-you');
    }
}
