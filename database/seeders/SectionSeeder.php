<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks before truncating the table
        Schema::disableForeignKeyConstraints();

        // Truncate the sections table to reset it
        Section::truncate();

        // Re-enable foreign key checks after truncating
        Schema::enableForeignKeyConstraints();

        // Create new sections
        Section::create(['name' => 'Section A', 'is_deleteable' => false]);
        Section::create(['name' => 'Section B', 'is_deleteable' => false]);
        Section::create(['name' => 'Section C', 'is_deleteable' => false]);
        Section::create(['name' => 'Section D', 'is_deleteable' => false]);
        Section::create(['name' => 'Section E', 'is_deleteable' => false]);
    }
}
