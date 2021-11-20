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
}
