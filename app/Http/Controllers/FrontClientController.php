<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class FrontClientController extends Controller
{
    public function index(){

		$id = Auth::user()->id;
		$clientname = User::find($id)->name;

		// dd($client->role);

		return view('client.index')->with($clientname);
	}
}
