<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch the user details from the config
        $name = config('admin_user.name');
        $email = config('admin_user.email');
        $password = config('admin_user.password');

        // If any of the values are empty, don't create the user
        if (empty($name) || empty($email) || empty($password)) {
            $this->command->error('Admin user not created. Please check your .env file.');
            return;
        }

        // If a user with the email address already exists, we'll update the name and password

        $user = User::where('email', $email)->first();

        if ($user) { // Update the existing user
            $user->update([
                'name' => $name,
                'password' => bcrypt($password),
            ]);

            $this->command->info('Admin user updated: ' . $email);
        } else { // Create a new user
            $user = User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
        }
    }
}
