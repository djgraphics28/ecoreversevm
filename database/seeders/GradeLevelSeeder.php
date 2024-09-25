<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks before truncating the table
        Schema::disableForeignKeyConstraints();

        // Truncate the grade_levels table to reset it
        GradeLevel::truncate();

        // Re-enable foreign key checks after truncating
        Schema::enableForeignKeyConstraints();

        // Create new grade levels
        GradeLevel::create(['name' => 'Grade I', 'is_deleteable' => false]);
        GradeLevel::create(['name' => 'Grade II', 'is_deleteable' => false]);
        GradeLevel::create(['name' => 'Grade III', 'is_deleteable' => false]);
        GradeLevel::create(['name' => 'Grade IV', 'is_deleteable' => false]);
        GradeLevel::create(['name' => 'Grade V', 'is_deleteable' => false]);
        GradeLevel::create(['name' => 'Grade VI', 'is_deleteable' => false]);
    }
}
