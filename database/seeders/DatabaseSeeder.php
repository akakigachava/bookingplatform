<?php

namespace Database\Seeders;

use App\Models\BusinessHour;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@bookease.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Sample staff member
        $staffUser = User::create([
            'name'     => 'Sarah Johnson',
            'email'    => 'sarah@bookease.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);
        Staff::create(['user_id' => $staffUser->id, 'bio' => 'Senior stylist with 8 years of experience.', 'is_active' => true]);

        $staffUser2 = User::create([
            'name'     => 'Mike Peters',
            'email'    => 'mike@bookease.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);
        Staff::create(['user_id' => $staffUser2->id, 'bio' => 'Specialises in colour and highlights.', 'is_active' => true]);

        // Services
        Service::insert([
            ['name' => 'Haircut',           'description' => 'Classic cut and style.',         'duration_minutes' => 45,  'price' => 150.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hair Colour',        'description' => 'Full colour treatment.',          'duration_minutes' => 120, 'price' => 450.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blow Dry',           'description' => 'Wash and blow dry.',             'duration_minutes' => 30,  'price' => 120.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beard Trim',         'description' => 'Shape and trim beard.',          'duration_minutes' => 30,  'price' => 80.00,  'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Spa Package',   'description' => 'Facial, massage & manicure.',   'duration_minutes' => 180, 'price' => 850.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manicure',           'description' => 'Nail shape, buff and polish.',  'duration_minutes' => 60,  'price' => 200.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Business hours: Mon–Sat open, Sunday closed
        foreach (range(0, 6) as $day) {
            BusinessHour::create([
                'day_of_week' => $day,
                'open_time'   => '09:00',
                'close_time'  => '18:00',
                'is_open'     => $day !== 0, // Sunday closed
            ]);
        }
    }
}
