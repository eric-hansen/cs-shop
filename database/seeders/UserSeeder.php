<?php

namespace Database\Seeders;

use App\Models\User;

class UserSeeder extends BaseSeeder
{
    public string $model = User::class;
    public string $filename = 'users.csv';
}
