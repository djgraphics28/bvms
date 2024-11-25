<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = Admin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.test',
            'password' => Hash::make('admin'),
        ]);

        // Post::factory()
        //     ->count(25)
        //     ->create();

        Notification::make()
            ->title('Welcome to BVMS Admin')
            ->body('You are ready to start building your application.')
            ->success()
            ->sendToDatabase($user);
    }
}
