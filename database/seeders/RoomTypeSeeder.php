<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $type = new RoomType();
         $type->name = 'private';
         $type->save();

         $type = new RoomType();
         $type->name = 'group';
         $type->save();
    }
}
