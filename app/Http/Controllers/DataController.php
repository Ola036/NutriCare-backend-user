<?php

namespace App\Http\Controllers;

class DataController extends Controller
{
    public function __invoke()
    {
        return config('data');
    }
}
