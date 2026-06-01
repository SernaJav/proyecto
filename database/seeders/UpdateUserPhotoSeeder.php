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

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->photo = 'javier.jpeg';
            $user->save();
            $this->command->info("Updated photo for {$email}");
        } else {
            $this->command->info("User {$email} not found.");
        }
    }
}
