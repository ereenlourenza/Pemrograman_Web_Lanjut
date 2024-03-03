<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function index($id,$name){
        return view('user')
        ->with('id', $id)
        ->with('name', $name);
    }
}