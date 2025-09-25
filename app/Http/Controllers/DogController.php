<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    
    public function get()
    {
        return response()->json(Dog::all());
    }
    
    public function store(Request $request)
    {
        $dog = Dog::create($request->only('nombre'));
        return response()->json($dog, 201);
    }

      
    public function index(Request $request)
    {
        $limit = (int) $request->query('limit', 0);
        $dogs = $limit > 0 ? Dog::limit($limit)->get() : Dog::all();
        return response()->json($dogs);
    }

    public function show($id)
    {
        $dog = Dog::find($id);
        if (!$dog) {
            return response()->json(['error' => 'El perro no existe'], 404);
        }
        return response()->json($dog);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        $dog = Dog::find($id);
        if (!$dog) {
            return response()->json(['error' => 'El perro no existe'], 404);
        }

        $dog->update($request->only('nombre'));
        return response()->json($dog);
    }

    public function destroy($id)
    {
        $dog = Dog::find($id);
        if (!$dog) {
            return response()->json(['error' => 'El perro no existe'], 404);
        }

        $dog->delete();
        return response()->json(['message' => 'Perro eliminado']);
    }
}