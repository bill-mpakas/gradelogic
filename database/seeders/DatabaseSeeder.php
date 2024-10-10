<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use App\Enums\RolesEnum;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = app(Role::class)->findOrCreate('admin');
        $studentRole = app(Role::class)->findOrCreate('student');
        $teacherRole = app(Role::class)->findOrCreate('teacher');
        $organizationRole = app(Role::class)->findOrCreate('organization');

        Classroom::factory()->count(10)->create();
        User::factory()->count(10)->create();

        $classroom1 = Classroom::factory()->create();


        // create admin user
        $adminUser = User::factory()->create([
            'name' => 'Super',
            'email' => 'admin@gradelogic.com',
            'password' => Hash::make('password'),
        ]);

        // create a user with the role of teacher
        $teacher = User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@gradelogic.com',
            'password' => Hash::make('password'),
        ]);

        // create a user with the role of student
        $student1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gradelogic.com',
            'password' => Hash::make('password'),
        ]);

        // 2nd student
        $student2 = User::factory()->create([
            'name' => 'Student2',
            'email' => 'student2@gradelogic.com',
            'password' => Hash::make('password'),
        ]);

        $adminUser->ulid = Str::ulid()->toBase32();
        $adminUser->email_verified_at = now();
        $adminUser->save(['timestamps' => false]);
        $adminUser->assignRole($adminRole);


        // asociate the teacher with a classroom
        $teacher->assignRole($teacherRole);
        $teacher->classrooms()->attach($classroom1);
        // assign to the teacher the class with the ID of 1
        $teacher->classrooms()->attach(1);
        $teacher->ulid = Str::ulid()->toBase32();
        $teacher->email_verified_at = now();
        $teacher->save(['timestamps' => false]);

        // asociate the student1 with the same classroom
        $student1->assignRole($studentRole);
        $student1->classrooms()->attach($classroom1);
        $student1->ulid = Str::ulid()->toBase32();
        $student1->email_verified_at = now();
        $student1->save(['timestamps' => false]);

        // asociate the student2 with another classroom
        $student2->assignRole($studentRole);
        $student2->classrooms()->attach(Classroom::factory()->create());
        $student2->ulid = Str::ulid()->toBase32();
        $student2->email_verified_at = now();
        $student2->save(['timestamps' => false]);


    }
}
