<?php

use App\Models\Visitor;
use Illuminate\Support\Carbon;

test('visiting a public page records a unique visit', function () {
    $this->get(route('home'))->assertOk();

    $this->assertDatabaseHas('visitors', [
        'ip_address' => '127.0.0.1',
    ]);

    expect(Visitor::count())->toBe(1);
});

test('subsequent visits by same IP on same day are ignored', function () {
    $this->get(route('home'))->assertOk();
    $this->get(route('home'))->assertOk();
    $this->get(route('profil'))->assertOk();

    expect(Visitor::count())->toBe(1);
});

test('visits by same IP on different days are recorded separately', function () {
    $this->get(route('home'))->assertOk();

    // Mock date to tomorrow
    Carbon::setTestNow(now()->addDay());

    $this->get(route('home'))->assertOk();

    expect(Visitor::count())->toBe(2);

    Carbon::setTestNow(); // Reset mock time
});

test('public layout footer displays visitor statistics', function () {
    // Seed some visits
    Visitor::factory()->create(['visit_date' => now()->toDateString()]); // Today
    Visitor::factory()->create(['visit_date' => now()->subDay()->toDateString()]); // Yesterday

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Kunjungan Website')
        ->assertSee('Hari Ini')
        ->assertSee('Kemarin')
        ->assertSee('Bulan Ini')
        ->assertSee('Total');
});
