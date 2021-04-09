<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function test()
    {
        dd(3);
    }
}