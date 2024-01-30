<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Http\Requests\StoreClotheRequest;
use App\Http\Requests\UpdateClotheRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ClotheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $clothes = Clothe::with('product.brand')->filter($request)->paginate(10);
        } catch (Exception  $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $clothes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $clothe = new Clothe();
            $clothe->type = $request->type;
            $clothe->size = $request->size;
            $clothe->color = $request->color;
            $clothe->material = $request->material;
            $clothe->product_id = $request->product_id;

            if ($request->file) {
                $path = Storage::putFile('public', $request->file);
                $link = env('APP_URL') . Storage::url($path);
                $clothe['url']=$link;
            }

            $clothe->save();
        }  catch (Exception $e) {
                return response()->json([
                    'data' => [
                        'code'   => $e->getCode(),
                        'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                        'errors' => $e->getMessage(),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        return response()->json([
            'message'    => 'Registrado exitosamente',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $clothe = Clothe::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'message'    => 'Hola',
            'response'   => $clothe,
        ]); ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $clothe = Clothe::find($id);
        if (!$clothe){
            return response()->json([
                'errors' => [
                    'message'   => 'No se encontro esta marca',
                ]
            ], 422);
        }
        try {
            $clothe = Clothe::findOrFail($id);
            $clothe->type = $request->type ?? $clothe->type = $request->type;
            $clothe->size = $request->size ?? $clothe->size = $request->size;
            $clothe->color = $request->color ?? $clothe->color = $request->color;
            $clothe->material = $request->material ?? $clothe->material = $request->material;
            $clothe->product_id = $request->product_id ?? $clothe->product_id = $request->product_id;

            if ($request->file) {
                $path = Storage::putFile('public', $request->file);
                $link = env('APP_URL') . Storage::url($path);
                $clothe['url']=$link;
            }

            $clothe->save();
            $response = Clothe::find($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'message'    => 'Registro Actualizado exitosamente',
            'response'   => $response,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $clothe = Clothe::findOrFail($id);
            $clothe->delete();
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'message'    => 'Registro Borrado exitosamente',
        ]);
    }

    public function restore($id)
    {
        $clothe = Clothe::find($id);
        if ($clothe){
            return response()->json([
                'errors' => [
                    'message'   => 'Esta marca no se encuentra eliminada',
                ]
            ], 422);
        }
        try {
            $clothe = Clothe::withTrashed()->findOrFail($id);
            $clothe->restore();

        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };

        return response()->json([
            'message'    => 'Restaurado exitosamente',
        ]);
    }
}
