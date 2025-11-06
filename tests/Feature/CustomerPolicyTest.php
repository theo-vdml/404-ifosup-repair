<?php

use App\Enums\UserRole;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to view any customers', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->can('viewAny', Customer::class))->toBeTrue();
});

it('allows technician to view any customers', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);

    expect($technician->can('viewAny', Customer::class))->toBeTrue();
});

it('allows admin to view specific customer', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $customer = Customer::factory()->create();

    expect($admin->can('view', $customer))->toBeTrue();
});

it('allows technician to view specific customer', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $customer = Customer::factory()->create();

    expect($technician->can('view', $customer))->toBeTrue();
});

it('allows admin to create customers', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->can('create', Customer::class))->toBeTrue();
});

it('denies technician from creating customers', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);

    expect($technician->can('create', Customer::class))->toBeFalse();
});

it('allows admin to update customers', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $customer = Customer::factory()->create();

    expect($admin->can('update', $customer))->toBeTrue();
});

it('denies technician from updating customers', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $customer = Customer::factory()->create();

    expect($technician->can('update', $customer))->toBeFalse();
});

it('allows admin to delete customers', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $customer = Customer::factory()->create();

    expect($admin->can('delete', $customer))->toBeTrue();
});

it('denies technician from deleting customers', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $customer = Customer::factory()->create();

    expect($technician->can('delete', $customer))->toBeFalse();
});
