<?php

use App\Models\ApbdesItem;
use App\Models\Complaint;
use App\Models\News;
use App\Models\Potency;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('dashboard shows summary statistics from the database', function () {
    $user = User::factory()->create();
    News::factory()->count(2)->create();
    Complaint::factory()->pending()->count(3)->create();
    Potency::factory()->count(4)->create();
    ApbdesItem::factory()->pendapatan()->create(['amount' => 100_000_000]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Berita')
        ->assertSee('2')
        ->assertSee('Aduan Pending')
        ->assertSee('3')
        ->assertSee('Potensi & UMKM')
        ->assertSee('4')
        ->assertSee('Rp 100.000.000');
});
