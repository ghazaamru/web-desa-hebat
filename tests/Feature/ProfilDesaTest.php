<?php

use App\Models\Apparatus;
use App\Models\VillageStatistic;

test('anyone can visit the profile page', function () {
    VillageStatistic::factory()->create(['label' => 'Visi', 'value' => 'Visi Dalangan yang maju']);
    VillageStatistic::factory()->create(['label' => 'Misi', 'value' => 'Misi 1. Melayani']);
    VillageStatistic::factory()->create(['label' => 'Sejarah', 'value' => 'Didirikan sejak zaman dahulu']);
    $apparatus = Apparatus::factory()->create(['name' => 'Bambang Sutrisno', 'position' => 'Kepala Desa']);

    $this->get(route('profil'))
        ->assertOk()
        ->assertSee('Visi Dalangan yang maju')
        ->assertSee('Misi 1. Melayani')
        ->assertSee('Didirikan sejak zaman dahulu')
        ->assertSee($apparatus->name)
        ->assertSee($apparatus->position);
});
