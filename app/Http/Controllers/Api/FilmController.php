<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // Filmleri listeler
    {
        $films = Film::all();
        return $films;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        if(Film::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Film zaten kayıtlı'
            ]);
        } else {
            Film::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);
        if($film) {
            return $film;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef film bulunamadı'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        if(Film::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Film zaten kayıtlı'
            ]);
        } else {
            $film = Film::find($id);
            if($film) {
                $film->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Güncelleme başarılı'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Hedef film bulunamadı'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);
        if($film) {
            $film->tickets()->delete();
            $film->visionfilms()->delete();
            $film->delete();
            return response()->json([
                'status' => true,
                'message' => 'Silme başarılı'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef film bulunamadı'
            ]);
        }
    }
}
