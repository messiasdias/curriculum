<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    /**
     * Create a new SiteController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth_jwt:api')->except(['indexWeb', 'indexApi']);
        $this->middleware('user_permission:slider')->except(['indexWeb', 'indexApi']);
    }

    public function indexWeb()
    {
        return view('index', [
            'title' => getenv('APP_NAME'),
            'message' => "Everything working as expected. :)"
        ]);
    }

    public function indexApi()
    {
        $appName = getenv('APP_NAME');
        return response()->json([
            'status' => "success",
            'message' => "{$appName} - Everything working as expected. :)"
        ]);
    }
}
