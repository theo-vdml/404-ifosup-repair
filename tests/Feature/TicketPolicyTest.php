<?php

use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to view any tickets', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->can('viewAny', Ticket::class))->toBeTrue();
});

it('allows technician to view any tickets', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);

    expect($technician->can('viewAny', Ticket::class))->toBeTrue();
});

it('allows admin to view specific ticket', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    expect($admin->can('view', $ticket))->toBeTrue();
});

it('allows technician to view specific ticket', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $ticket = Ticket::factory()->create();

    expect($technician->can('view', $ticket))->toBeTrue();
});

it('allows admin to create tickets', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->can('create', Ticket::class))->toBeTrue();
});

it('denies technician from creating tickets', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);

    expect($technician->can('create', Ticket::class))->toBeFalse();
});

it('allows admin to update tickets', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    expect($admin->can('update', $ticket))->toBeTrue();
});

it('denies technician from updating tickets', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $ticket = Ticket::factory()->create();

    expect($technician->can('update', $ticket))->toBeFalse();
});

it('allows admin to update ticket status', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    expect($admin->can('updateStatus', $ticket))->toBeTrue();
});

it('denies technician from updating ticket status', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $ticket = Ticket::factory()->create();

    expect($technician->can('updateStatus', $ticket))->toBeFalse();
});

it('allows admin to update ticket priority', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    expect($admin->can('updatePriority', $ticket))->toBeTrue();
});

it('denies technician from updating ticket priority', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $ticket = Ticket::factory()->create();

    expect($technician->can('updatePriority', $ticket))->toBeFalse();
});

it('allows admin to assign users to tickets', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    expect($admin->can('assignUser', $ticket))->toBeTrue();
});

it('denies technician from assigning users to tickets', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $ticket = Ticket::factory()->create();

    expect($technician->can('assignUser', $ticket))->toBeFalse();
});

it('allows admin to add notes to tickets', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    expect($admin->can('addNote', $ticket))->toBeTrue();
});

it('allows technician to add notes to tickets', function () {
    $technician = User::factory()->create(['role' => UserRole::Technician]);
    $ticket = Ticket::factory()->create();

    expect($technician->can('addNote', $ticket))->toBeTrue();
});
