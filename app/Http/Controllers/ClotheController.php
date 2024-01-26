<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Http\Requests\StoreClotheRequest;
use App\Http\Requests\UpdateClotheRequest;

class ClotheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClotheRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Clothe $clothe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClotheRequest $request, Clothe $clothe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clothe $clothe)
    {
        //
    }
}
