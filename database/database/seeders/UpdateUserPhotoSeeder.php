<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUserPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'jamaseos77@gmail.com';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Javier',
                'password' => bcrypt('12345678'),
                'photo' => 'javier.jpeg',
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->command->info("Created user {$email} with photo javier.jpeg");
        } else {
            $user->photo = 'javier.jpeg';
            $user->save();
            $this->command->info("Updated photo for {$email}");
        }
    }
}

