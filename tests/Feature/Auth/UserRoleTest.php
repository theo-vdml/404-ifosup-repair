<?php

use App\Enums\UserRole;
use App\Models\User;

test('users role is technician by default', function () {
    $user = User::factory()->create([
        'name' => 'Default Role User',
        'email' => 'default@example.com',
    ]);

    expect($user->role)->toBe(UserRole::Technician);
});

test('admin user can be created with admin role', function () {
    $user = User::factory()->admin()->create([
        'name' => 'Admin Role User',
        'email' => 'admin@example.com',
    ]);

    expect($user->role)->toBe(UserRole::Admin);
});

test('user role is correctly stored in the database', function () {
    $user = User::factory()->admin()->create([
        'name' => 'Admin DB User',
        'email' => 'admin_db@example.com',
    ]);

    $dbUser = User::find($user->id);
    expect($dbUser->role)->toBe(UserRole::Admin);
});

test('invalid role cannot be assigned', function () {
    $this->expectException(ValueError::class);

    User::factory()->create([
        'name' => 'Invalid Role User',
        'email' => 'invalid_role@example.com',
        'role' => 'invalid_role',
    ]);
});
