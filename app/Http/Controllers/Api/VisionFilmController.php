<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisionFilm;
use Illuminate\Http\Request;
use App\Models\Cinema;

class VisionFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // cinema_id sinemasındaki filmleri listeler
    {
        $data = $request->validate([
            'cinema_id' => 'required|numeric|exists:App\Models\Cinema,id',
        ]);

        $cinema = Cinema::find($data["cinema_id"]);
        $visionfilms = $cinema->visionfilms;
        foreach($visionfilms as $visionfilm) {
            $visionfilm["film"] = $visionfilm->film;
        }

        return $visionfilms;
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
            'cinema_id' => 'required|numeric|exists:App\Models\Cinema,id',
            'film_id' => 'required|numeric|exists:App\Models\Film,id',
        ]);

        if(VisionFilm::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Film zaten vizyonda kayıtlı'
            ]);
        } else {
            VisionFilm::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisionFilm  $visionFilm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visionfilm = VisionFilm::find($id);
        if($visionfilm) {
            return $visionfilm;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef vizyon filmi bulunamadı'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisionFilm  $visionFilm
     * @return \Illuminate\Http\Response
     */
    public function edit(VisionFilm $visionFilm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisionFilm  $visionFilm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cinema_id' => 'required|numeric|exists:App\Models\Cinema,id',
            'film_id' => 'required|numeric|exists:App\Models\Film,id',
        ]);

        if(VisionFilm::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Film zaten vizyonda kayıtlı'
            ]);
        } else {
            $visionfilm = VisionFilm::find($id);
            if($visionfilm) {
                $visionfilm->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Güncelleme başarılı'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Hedef vizyon filmi bulunamadı'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisionFilm  $visionFilm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visionfilm = VisionFilm::find($id);
        if($visionfilm) {
            $visionfilm->tickets()->delete();
            $visionfilm->delete();
            return response()->json([
                'status' => true,
                'message' => 'Silme başarılı'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef vizyon filmi bulunamadı'
            ]);
        }
    }
}
