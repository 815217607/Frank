<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


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

//        dump(access());die;
//        $this->middleware('admin');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('backend.dashboard');
    }
}