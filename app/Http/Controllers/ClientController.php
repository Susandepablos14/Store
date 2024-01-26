<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Exception;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $clients = Client::Filter($request)->paginate(10);
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
            'title' => 'clients found',
            'message' => $clients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $client = new Client();
            $client->name = $request->name;
            $client->last_name = $request->last_name;
            $client->address = $request->address;
            $client->state_id = $request->state_id;
            $client->phone = $request->phone;
            $client->email = $request->address;
            $client->ci = $request->ci;

            $client->save();
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
        'title' => 'Successful registration',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $client = Client::FindOrFail($id);
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
            'title' => 'client found',
            'message' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $client = Client::Find($id);
        if (!$client){
            return response()->json([
            'message' => 'No es posible editar esté cliente',
            ],422);
        }try {
            $client->name = $request->name ?? $client->name;
            $client->last_name = $request->last_name ?? $client->last_name;
            $client->address = $request->address ?? $client->address;
            $client->state_id = $request->state_id ?? $client->state_id;
            $client->phone = $request->phone ?? $client->phone;
            $client->email = $request->address ?? $client->email;
            $client->ci = $request->ci ?? $client->ci;
            $client->save();
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
    public function destroy(Request $request, $id)
    {
        try {
            $client = Client::FindOrFail($id);
            $client->delete();
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
            'message' => 'Client deleted',
        ]);
    }

    public function restore($id)
    {
        $client = Client::Find($id);
        if ($client){
            return response()->json([
            'message' => 'No es posible restaurar esté cliente',
            ],422);
        }
        try {
            $client = Client::withTrashed()->FindOrFail($id);
            $client->restore();
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
        'title' => 'Client restore',
        'message' => $client,
        ]);
    }
}
