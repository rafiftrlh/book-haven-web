<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function index()
    {
        return view("roles.officer.index");
    }
    public function addCategory()
    {
        return view("roles.officer.index");
    }

}
