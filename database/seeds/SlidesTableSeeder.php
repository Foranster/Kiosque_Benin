<?php

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        for ($i = 1; $i <= 5; $i++){
            \Illuminate\Support\Facades\DB::table('slides')->insert([
                'image' => 'Slide-'.$i,
                'title' => 'Titre du slide n° '.$i,
                'description' => 'Description du slide n° '.$i,
            ]);
        }
    }
}
