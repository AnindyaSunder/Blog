<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorDashController extends Controller
{
    public function index()
    {
    	return view('author.authorDash');
    }
}
