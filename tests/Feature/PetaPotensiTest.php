<?php

use App\Models\Potency;
use Livewire\Livewire;

test('anyone can visit the peta potensi page', function () {
    $response = $this->get(route('peta-potensi'));
    $response->assertOk();
});

test('peta potensi renders all active potencies', function () {
    $potencies = Potency::factory()->count(3)->create();

    $component = Livewire::test('pages::peta-potensi')
        ->assertOk();

    foreach ($potencies as $potency) {
        $component->assertSee($potency->title);
    }
});

test('peta potensi category filter updates displayed list', function () {
    $bumdes = Potency::factory()->bumdes()->create();
    $umkm = Potency::factory()->umkm()->create();

    $component = Livewire::test('pages::peta-potensi')
        ->assertSee($bumdes->title)
        ->assertSee($umkm->title)
        ->set('filters.bumdes', false)
        ->assertDontSee($bumdes->title)
        ->assertSee($umkm->title);
});

test('peta potensi dispatches filtered potencies when a filter is toggled', function () {
    $bumdes = Potency::factory()->bumdes()->create(['title' => 'BUMDes Tersembunyi']);
    $umkm = Potency::factory()->umkm()->create(['title' => 'UMKM Terlihat']);

    Livewire::test('pages::peta-potensi')
        ->set('filters.bumdes', false)
        ->assertDispatched('potencies-updated', function (string $name, array $params) use ($bumdes, $umkm) {
            $names = collect($params['potencies'])->pluck('name');

            return $names->contains($umkm->title) && ! $names->contains($bumdes->title);
        });
});

test('peta potensi renders facility potencies', function () {
    $fasilitas = Potency::factory()->fasilitas()->create(['title' => 'SD Negeri 01 Dalangan']);

    Livewire::test('pages::peta-potensi')
        ->assertSee($fasilitas->title)
        ->set('filters.fasilitas', false)
        ->assertDontSee($fasilitas->title);
});
