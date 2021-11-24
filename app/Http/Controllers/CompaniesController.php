<?php

namespace App\Http\Controllers;

use Auth;

class CompaniesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!Auth::check())
            return view('admin.companies.index');
        if ($user->isAdmin())
            return view('manager.index');
        else
            return view('admin.companies.index');
    }

    public function test()
    {
        try {
            $lines = collect(file(base_path() . '/RS232.txt'))->map(function ($item) {
                return explode("\t", $item);
            });

            dd($lines);
            //code...
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }
    }
}
