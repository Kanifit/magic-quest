<?php

use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langs = config('book.langs');

        foreach ($langs as $code => $title) 
        {
            $langSeed[] = ['code' => $code, 'title' => $title];
        }

        DB::table('langs')->insert($langSeed);
    }
}
