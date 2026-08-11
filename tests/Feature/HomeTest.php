<?php

use App\Models\ApbdesItem;
use App\Models\Apparatus;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Potency;
use App\Models\VillageStatistic;

test('anyone can visit the home page', function () {
    $this->get(route('home'))->assertOk();
});

test('home page renders village statistics from database', function () {
    $stat = VillageStatistic::factory()->create(['label' => 'Total Penduduk', 'value' => '4.250']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($stat->label)
        ->assertSee($stat->value);
});

test('home page renders apbdes income and spending from database', function () {
    $pendapatan = ApbdesItem::factory()->pendapatan()->create(['name' => 'Dana Desa (APBN)', 'amount' => 820_000_000]);
    $belanja = ApbdesItem::factory()->belanja()->create(['name' => 'Pembangunan Infrastruktur', 'amount' => 640_000_000]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($pendapatan->name)
        ->assertSee($belanja->name);
});

test('home page renders umkm and wisata potencies', function () {
    $umkm = Potency::factory()->umkm()->create(['title' => 'Keripik Tempe Renyah']);
    $wisata = Potency::factory()->wisata()->create(['title' => 'Curug Indah']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($umkm->title)
        ->assertSee($wisata->title);
});

test('home page map renders all potencies from database', function () {
    $bumdes = Potency::factory()->bumdes()->create(['title' => 'BUMDes Sejahtera']);
    $fasilitas = Potency::factory()->fasilitas()->create(['title' => 'Kantor Desa Dalangan']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($bumdes->title)
        ->assertSee($fasilitas->title);
});

test('home page renders only published news', function () {
    $published = News::factory()->published()->create(['title' => 'Berita Terbaru Desa']);
    News::factory()->unpublished()->create(['title' => 'Berita Draf Rahasia']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee('Berita Draf Rahasia');
});

test('home page renders apparatus from database', function () {
    $apparatus = Apparatus::factory()->create(['name' => 'Bambang Sutrisno', 'position' => 'Kepala Desa']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($apparatus->name)
        ->assertSee($apparatus->position);
});

test('home page renders welcome message from kepala desa', function () {
    $kades = Apparatus::factory()->create([
        'name' => 'Bambang Sutrisno',
        'position' => 'Kepala Desa',
        'welcome_message' => 'Selamat datang di Desa Dalangan',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($kades->welcome_message)
        ->assertSee('Sambutan');
});

test('home page renders galleries from database', function () {
    $gallery = Gallery::factory()->create(['title' => 'Dokumentasi Kerja Bakti']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($gallery->title);
});
