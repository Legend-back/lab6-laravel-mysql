<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatController extends Controller
{
    public function get()
    {
        $gatos = DB::select("SELECT * FROM gatos");
        return response()->json($gatos);
    }

    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        DB::insert("INSERT INTO gatos (nombre) VALUES (?)", [$nombre]);
        return response()->json(['message' => 'Gato agregado']);
    }

    public function index(Request $request)
    {
        $limit = (int) $request->query('limit', 0);
        if ($limit > 0) {
            $gatos = DB::select('SELECT * FROM gatos LIMIT ?', [$limit]);
        } else {
            $gatos = DB::select('SELECT * FROM gatos');
        }
        return response()->json($gatos);
    }

    public function show($id)
    {
        $rows = DB::select('SELECT * FROM gatos WHERE id = ?', [$id]);
        if (count($rows) === 0) {
            return response()->json(['error' => 'El gato no existe'], 404);
        }
        return response()->json($rows[0]);
    }

    public function update(Request $request, $id)
    {
        $nombre = $request->input('nombre');
        if (!$nombre) {
            return response()->json(['error' => 'nombre es requerido'], 422);
        }

        $affected = DB::update('UPDATE gatos SET nombre = ? WHERE id = ?', [$nombre, $id]);
        if ($affected === 0) {
            return response()->json(['error' => 'El gato no existe'], 404);
        }

        $row = DB::select('SELECT * FROM gatos WHERE id = ?', [$id]);
        return response()->json($row[0]);
    }

    public function destroy($id)
    {
        $affected = DB::delete('DELETE FROM gatos WHERE id = ?', [$id]);
        if ($affected === 0) {
            return response()->json(['error' => 'El gato no existe'], 404);
        }
        return response()->json(['message' => 'Gato eliminado']);
    }
}