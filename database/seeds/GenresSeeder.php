<?php

use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = config('book.genres');

        foreach ($genres as $code => $title) 
        {
            $genresSeed[] = ['code' => $code, 'title' => $title];
        }

        DB::table('genres')->insert($genresSeed);
    }
}
