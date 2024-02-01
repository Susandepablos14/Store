<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;

use exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $state = State::Filter($request)->paginate(10);
        }catch(exception $e){
            return response()->json([
            'data' => [
            'code' => $e -> getCode(),
            'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
            'errors' => $e->getMessage(),
            ]], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
        'title' => 'clients found',
        'message' => $state,]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $state = new State();
            $state->name = $request ->name;

            $state->save();
        }catch (Exception $e){
            return response()->json([
                'data'=>[
                'code' => $e -> getCode(),
                'title'=>'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' =>$e->getMessage(),
                ]
            ], response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'title' => 'Success resgistration',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $state = State::findOrFail($id);
        }catch (exception $e){
            return response()->json([
                'data' =>[
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage()
                ]
            ]);
        }
        return response()->json([
            'title' => 'client found',
            'message' => $state,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $state = State::Find($id);
        if (!$state){
            return response()->json([
            'message' => 'No es posible editar esté Estado',
            ],422);
        }try {
            $state->name = $request->name ?? $state->name;
            $state->save();
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'title' => 'Successful update',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $state = State::FindOrFail($id);
            $state->delete();
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'message' => 'State deleted',
        ]);
    }

    public function restore($id)
    {
        $state = State::Find($id);
        if ($state){
            return response()->json([
            'message' => 'No es posible restaurar esté estado',
            ],422);
        }
        try {
            $state = State::withTrashed()->FindOrFail($id);
            $state->restore();
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
        'title' => 'State restore',
        'message' => $state,
        ]);
    }
}
