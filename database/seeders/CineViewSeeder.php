<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CineViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(['name' => 'Kerem', 'email' => 'a.keremcelik@outlook.com', 'password' => Hash::make('123')]);

        $cities = ['Antalya', 'Ankara', 'İstanbul'];
        foreach($cities as $city) {
            \App\Models\City::create(['name' => $city]);
        }

        $cinemas = array(
            ['city_id' => 1, 'name' => 'Cinemaximum'],
            ['city_id' => 2, 'name' => 'Cinemaximum'],
            ['city_id' => 3, 'name' => 'Cinemaximum'],
            ['city_id' => 1, 'name' => 'Cinema Red'],
            ['city_id' => 2, 'name' => 'Cinema Blue'],
            ['city_id' => 3, 'name' => 'Cinema Green'],
            ['city_id' => 2, 'name' => 'Cinema Orange'],
        );
        foreach($cinemas as $cinema) {
            \App\Models\Cinema::create($cinema);
        }

        $films = ['The Phantom of the Opera', 'Dracula', 'Frankenstein', 'The Old Dark House', 'Island of Lost Souls', 'The Mummy', 'White Zombie'];
        foreach($films as $film) {
            \App\Models\Film::create(['name' => $film]);
        }

        $visionfilms = array(
            ['cinema_id' => 1, 'film_id' => 1],
            ['cinema_id' => 1, 'film_id' => 2],
            ['cinema_id' => 2, 'film_id' => 2],
            ['cinema_id' => 2, 'film_id' => 3],
            ['cinema_id' => 3, 'film_id' => 1],
            ['cinema_id' => 3, 'film_id' => 3],
            ['cinema_id' => 3, 'film_id' => 4],
            ['cinema_id' => 3, 'film_id' => 5]
        );
        foreach($visionfilms as $visionfilm) {
            \App\Models\VisionFilm::create($visionfilm);
        }

        $tickets = array(
            ['user_id' => 1, 'visionfilm_id' => 1, 'seat_id' => 1],
            ['user_id' => 1, 'visionfilm_id' => 1, 'seat_id' => 2],
            ['user_id' => 1, 'visionfilm_id' => 1, 'seat_id' => 9],
            ['user_id' => 1, 'visionfilm_id' => 1, 'seat_id' => 10],
            ['user_id' => 1, 'visionfilm_id' => 5, 'seat_id' => 3],
            ['user_id' => 1, 'visionfilm_id' => 5, 'seat_id' => 4],
            ['user_id' => 1, 'visionfilm_id' => 6, 'seat_id' => 24],
        );
        foreach($tickets as $ticket) {
            \App\Models\Ticket::create($ticket);
        }
    }
}
