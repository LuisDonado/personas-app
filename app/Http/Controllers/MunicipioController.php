<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipioController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$municipios = municipio::all();
        $municipios =DB::table('tb_municipio')
        ->join('tb_departamento', 'tb_municipio.muni_codi', '=', 'tb_departamento.depa_codi')
        ->select('tb_municipio.*', "tb_departamento.depa_nomb")
        ->get();
        return view('municipio.index', ['municipios' => $municipios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = DB::table('tb_departamento')
            ->orderBy('depa_nomb')
            ->get();
            return view('municipio.new', ['departamentos' => $departamentos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $municipio = new Municipio();
        $municipio->muni_nomb = $request->name;
        $municipio->depa_codi = $request->code;
        $municipio->save();

        $municipios = DB::table('tb_municipio')
            ->join('tb_departamento', 'tb_municipio.depa_codi', '=' , 'tb_departamento.depa_codi')
            ->select('tb_municipio.*', "tb_departamento.depa_nomb")
            ->get();
        return view('municipio.index', ['municipios' => $municipios]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $municipio = municipio::find($id);
        $municipios = DB::table('tb_municipio')
            ->orderBy('muni_nomb')
            ->get();
        return view('municipio.edit', ['municipio' => $municipio, 'departamentos' => $departamentos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $municipio = municipio::find($id);

        $municipio->muni_nomb = $request->name;
        $municipio->depa_codi = $request->code;
        $municipio->save();

        $municipios = DB::table('tb_municipio')
            ->join('tb_municipio', 'tb_municipio.depa_codi', '=' , 'tb_departamento.depa_codi')
            ->select('tb_municipio.*', "tb_departamento.depa_nomb")
            ->get();
        return view('municipio.index', ['municipios' => $municipios]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $municipio = municipio::find($id);
        $municipio->delete();

        $municipios = DB::table('tb_municipio')
            ->join('tb_municipio', 'tb_municipio.depa_codi', '=' , 'tb_departamento.depa_codi')
            ->select('tb_municipio.*', "tb_departamento.depa_nomb")
            ->get();

        return view('municipio.index', ['municipios' => $municipios]);

    }
}
