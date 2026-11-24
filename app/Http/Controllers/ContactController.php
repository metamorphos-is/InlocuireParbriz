<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
