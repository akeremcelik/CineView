<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // Şehirleri listeler
    {
        $cities = City::all();
        return $cities;
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

        if(City::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Şehir zaten kayıtlı'
            ]);
        } else {
            City::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);
        if($city) {
            return $city;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef şehir bulunamadı'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        if(City::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Şehir zaten kayıtlı'
            ]);
        } else {
            $city = City::find($id);
            if($city) {
                $city->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Güncelleme başarılı'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Hedef şehir bulunamadı'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        if($city) {
            $cinemas = $city->cinemas;
            foreach($cinemas as $cinema) {
                $cinema->tickets()->delete();
                $cinema->visionfilms()->delete();
                $cinema->delete();
            }

            $city->delete();
            return response()->json([
                'status' => true,
                'message' => 'Silme başarılı'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef şehir bulunamadı'
            ]);
        }
    }
}
