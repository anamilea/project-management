<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
  
    public function __construct() {
        $this->middleware(['auth', 'admin']); 
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        //Get all users and pass it to the view
            $users = User::all(); 
            return view('users.index')->with('users', $users);
        }

        public function show($id) {
            return redirect('users'); 
        }
}
