<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExempleController extends Controller
{
    public function homePage()
    {
        return view("homePage");
    }

    public function aboutPage()
    {
        return view("single-post");
    }
}
