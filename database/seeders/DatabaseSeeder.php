<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use App\Enums\RolesEnum;
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

        // create roles and assign existing permissions
        // $role1 = Role::create(['name' => 'admin']);
        // $role2 = Role::create(['name' => 'user']);
        // $role3 = Role::create(['name' => 'teacher']);
        // $role4 = Role::create(['name' => 'student']);

        $studentRole = app(Role::class)->findOrCreate('student');
        $teacherRole = app(Role::class)->findOrCreate('teacher');
        $organizationRole = app(Role::class)->findOrCreate('organization');


        // create admin user
        $user1 = \App\Models\User::factory()->create([
            'name' => 'Super',
            'email' => 'admin@gradelogic.com',
            'password' => Hash::make('password'),
        ]);

        // create a user with the role of teacher
        $user2 = \App\Models\User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@gradelogic.com',
            'password' => Hash::make('password'),
        ]);


        // create a user with the role of student
        $user3 = \App\Models\User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gradelogic.com',
            'password' => Hash::make('password'),
        ]);

        $user1->ulid = Str::ulid()->toBase32();
        $user1->email_verified_at = now();
        $user1->save(['timestamps' => false]);

        $user1->assignRole($studentRole);

        $user2->ulid = Str::ulid()->toBase32();
        $user2->email_verified_at = now();
        $user2->save(['timestamps' => false]);

        $user2->assignRole($teacherRole);
    }
}
