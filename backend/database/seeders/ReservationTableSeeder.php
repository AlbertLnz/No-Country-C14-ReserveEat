<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReservationTable;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\ReservationSpecs;

class ReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_count = intval(User::count());
        $restaurant_count = intval(Restaurant::count());

        (new ReservationSpecsSeeder)->run();
        $lastIdCreated = ReservationSpecs::latest()->first()->id; // recopila el id que crea en la anterior linea (23)
        $num_of_persons = ReservationSpecs::select('quantity_people')->where('id', $lastIdCreated)->first()->quantity_people; // recopila el nº personas de linea 23

        $restaurant_selected =  rand(1, $restaurant_count); // random restaurant

        // ¡¡¡PUEDE NO FUNCIONAR!!!
        // ¿POR QUE? PORQUE ASIGNA, POR EJEMPLO, EL RESTAURANTE 1 PERO COMO NO HAY CAPACIDAD DE 10 PERSONAS (porque a la hora de hacer el TablesSeeder no pone ninguna de como mínimo 10), $table_selected === null Y PETA EL MIGRATE!
        $table_selected = Table::where('restaurant_id', $restaurant_selected)->where('capacity', '>=', $num_of_persons)->where('is_Taken', '=', false)->inRandomOrder()->first()->id;
        Table::where('id', $table_selected)->update(['is_taken' => true]); // table reservation

        ReservationTable::create([
            'reservation_table_specs' => $lastIdCreated,
            'user_id' => rand(1, $user_count),
            'restaurant_id' => $restaurant_selected,
            'table_id' => $table_selected,
        ]);
    }
}