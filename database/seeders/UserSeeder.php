<?php

namespace Database\Seeders;

use App\Models\User;

class UserSeeder extends BaseSeeder
{
    public string $model = User::class;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->processCsvData('users');
    }
}
