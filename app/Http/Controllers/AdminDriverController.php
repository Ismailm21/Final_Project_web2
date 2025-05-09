<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class AdminDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Driver::all();
        return View("admin.driver")->with("data",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View("addDriver");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Driver::create($request->all());
        return redirect()->route("driverR.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obj = Driver::findOrFail($id);
        return View("showDriver")->with("data",$obj);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $obj = Driver::findOrFail($id);
        return View("driver",compact("obj"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = Driver::findOrFail($id);
        $obj->fill($request->all());
        $obj->save();
        return redirect()->route("driverR.index");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obj = Driver::findOrFail($id);
        $obj->delete();
        return redirect()->route("driverR.index");

    }

    public function test(){
        return "Test";
    }
}

