<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;
use App\Models\City;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // city_id şehrindeki sinemaları listeler
    {
        $data = $request->validate([
            'city_id' => 'required|numeric|exists:App\Models\City,id',
        ]);

        $city = City::find($data["city_id"]);
        return $city->cinemas;
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
            'city_id' => 'required|numeric|exists:App\Models\City,id',
            'name' => 'required'
        ]);

        if(Cinema::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Sinema zaten kayıtlı'
            ]);
        } else {
            Cinema::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cinema = Cinema::find($id);
        if($cinema) {
            return $cinema;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef sinema bulunamadı'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function edit(Cinema $cinema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'city_id' => 'required|numeric|exists:App\Models\City,id',
            'name' => 'required'
        ]);

        if(Cinema::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Sinema zaten kayıtlı'
            ]);
        } else {
            $cinema = Cinema::find($id);
            if($cinema) {
                $cinema->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Güncelleme başarılı'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Hedef sinema bulunamadı'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cinema = Cinema::find($id);
        if($cinema) {
            $cinema->tickets()->delete();
            $cinema->visionfilms()->delete();
            $cinema->delete();
            return response()->json([
                'status' => true,
                'message' => 'Silme başarılı'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef sinema bulunamadı'
            ]);
        }
    }
}
