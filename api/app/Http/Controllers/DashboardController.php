<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeline;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_jwt:api');
    }

    public function timeline(Request $request)
    {
        return response()->json(['timeline' => Timeline::getTimeline(
            $request->filter['period']['start'], 
            $request->filter['period']['end'],
            $request->lasts ?: 200
        )], 200);
    }
    
    public function navegations(Request $request)
    {
        return response()->json(Timeline::getPageNavegations(
            $request->filter['period']['start'], 
            $request->filter['period']['end']
        ), 200);
    }
}
