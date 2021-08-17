<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\VisionFilm;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // visionfilm_id filmindeki boş koltukları listeler
    {
        $data = $request->validate([
            'visionfilm_id' => 'required|numeric|exists:App\Models\VisionFilm,id',
        ]);

        //$visionfilm = VisionFilm::find($data["visionfilm_id"]);
        $empty_seats = array();
        for($i=1; $i<51; $i++) {
            array_push($empty_seats, $i);
        }

        $tickets = Ticket::where($data)->get();
        foreach($tickets as $ticket) {
            array_splice($empty_seats, array_search($ticket->seat_id, $empty_seats ), 1);
        }

        return $empty_seats;
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
            'visionfilm_id' => 'required|numeric|exists:App\Models\VisionFilm,id',
            'seat_id' => 'required|numeric'
        ]);
        $data["user_id"] = $request->user()->id;

        //$visionfilm = VisionFilm::find($data["visionfilm_id"]);
        if(Ticket::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Bilet zaten alınmış'
            ]);
        } else {
            Ticket::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        if($ticket) {
            return $ticket;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef bilet bulunamadı'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'visionfilm_id' => 'required|numeric|exists:App\Models\VisionFilm,id',
            'seat_id' => 'required|numeric'
        ]);
        $data["user_id"] = $request->user()->id;
        
        //$visionfilm = VisionFilm::find($data["visionfilm_id"]);
        if(Ticket::where($data)->first()) {
            return response()->json([
                'status' => false,
                'message' => 'Bilet zaten alınmış'
            ]);
        } else {
            $ticket = Ticket::find($id);
            if($ticket) {
                $ticket->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Güncelleme başarılı'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Hedef bilet bulunamadı'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if($ticket) {
            $ticket->delete();
            return response()->json([
                'status' => true,
                'message' => 'Silme başarılı'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hedef bilet bulunamadı'
            ]);
        }
    }
}
