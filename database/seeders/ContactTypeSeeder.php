<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactType::create(['name' => 'Partner']);
        ContactType::create(['name' => 'Team']);
        ContactType::create(['name' => 'Client']);
    }
}
