<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;



/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin_auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('backend.dashboard');
    }
}