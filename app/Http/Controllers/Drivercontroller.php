<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Drivercontroller extends Controller
{
    public function index()
    {
        return view("driver.driverMenu");  // Ensure you have a 'client/dashboard.blade.php' view
    }
}
