<?php

namespace App\Database\Seeds;

use App\Models\User;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $first = $user->find();
        if (empty($first)) {
            $data = [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT)
            ];
            $user->insert($data);
        }
    }
}
