<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\models\Video;
use Illuminate\Http\Request;

class HomeControllerApi extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => auth()->user()->videos()->paginate(5),
            'message' => "success",
        ]);
    }

    
}
