<?php

namespace Database\Seeders;

use App\Models\Counter;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed service types
        ServiceType::insert([
            ['name' => 'Document Request', 'code' => 'DOC', 'description' => 'Requests for official documents', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Enrollment', 'code' => 'ENR', 'description' => 'Student enrollment transactions', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Payment', 'code' => 'PAY', 'description' => 'Fee and payment transactions', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'General Inquiry', 'code' => 'GEN', 'description' => 'General walk-in inquiries', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed counters (staff windows)
        Counter::insert([
            ['name' => 'Window 1', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Window 2', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Window 3', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
