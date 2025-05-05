<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Drivercontroller extends Controller
{
    public function index()
    {
        return "Welcome To driver Dashboard";  // Ensure you have a 'client/dashboard.blade.php' view
    }
}
