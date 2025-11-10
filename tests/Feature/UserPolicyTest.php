<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to view any users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->can('viewAny', User::class))->toBeTrue();
});

it('denies technician from viewing any users', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);

    expect($technician->can('viewAny', User::class))->toBeFalse();
});

it('allows admin to view specific user', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create();

    expect($admin->can('view', $user))->toBeTrue();
});

it('denies technician from viewing specific user', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $user = User::factory()->create();

    expect($technician->can('view', $user))->toBeFalse();
});

it('allows admin to create users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->can('create', User::class))->toBeTrue();
});

it('denies technician from creating users', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);

    expect($technician->can('create', User::class))->toBeFalse();
});

it('allows admin to update users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create();

    expect($admin->can('update', $user))->toBeTrue();
});

it('denies technician from updating users', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $user = User::factory()->create();

    expect($technician->can('update', $user))->toBeFalse();
});

it('allows admin to delete users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create();

    expect($admin->can('delete', $user))->toBeTrue();
});

it('denies technician from deleting users', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $user = User::factory()->create();

    expect($technician->can('delete', $user))->toBeFalse();
});
