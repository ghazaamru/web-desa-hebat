<?php

use App\Models\Potency;
use Livewire\Livewire;

test('anyone can visit the katalog usaha page', function () {
    $response = $this->get(route('katalog-usaha'));
    $response->assertOk();
});

test('katalog usaha search filters products', function () {
    $potency1 = Potency::factory()->umkm()->create(['title' => 'Usaha Tempe Enak']);
    $potency2 = Potency::factory()->wisata()->create(['title' => 'Wisata Air Terjun']);

    Livewire::test('pages::katalog-usaha')
        ->assertSee($potency1->title)
        ->assertSee($potency2->title)
        ->set('search', 'Tempe')
        ->assertSee($potency1->title)
        ->assertDontSee($potency2->title);
});

test('katalog usaha category button filters products', function () {
    $bumdes = Potency::factory()->bumdes()->create(['title' => 'BUMDes Desa Hebat']);
    $umkm = Potency::factory()->umkm()->create(['title' => 'UMKM Kripik Pisang']);

    Livewire::test('pages::katalog-usaha')
        ->assertSee($bumdes->title)
        ->assertSee($umkm->title)
        ->call('setCategory', 'bumdes')
        ->assertSee($bumdes->title)
        ->assertDontSee($umkm->title);
});

test('katalog usaha does not list public facilities', function () {
    $umkm = Potency::factory()->umkm()->create(['title' => 'Usaha Kopi Dalangan']);
    $fasilitas = Potency::factory()->fasilitas()->create(['title' => 'Puskesmas Pembantu']);

    Livewire::test('pages::katalog-usaha')
        ->assertSee($umkm->title)
        ->assertDontSee($fasilitas->title);
});
