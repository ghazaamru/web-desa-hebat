<?php

use App\Models\Apparatus;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Potency;
use App\Models\User;
use App\Models\VillageStatistic;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('guests are redirected from manage content page', function () {
    $this->get(route('manage-content'))
        ->assertRedirect(route('login'));
});

test('non-admin users cannot access manage content page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('manage-content'))
        ->assertForbidden();
});

test('admin users can access manage content page', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('manage-content'))
        ->assertOk();
});

test('admin can create and edit news via livewire actions and upload image', function () {
    Storage::fake('public');
    $user = User::factory()->admin()->create();
    $file = UploadedFile::fake()->image('news.jpg');

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('newsTitle', 'Berita Baru Desa')
        ->set('newsExcerpt', 'Ringkasan berita')
        ->set('newsContent', 'Isi lengkap berita')
        ->set('newsImageUpload', $file)
        ->set('newsIsPublished', true)
        ->call('saveNews')
        ->assertHasNoErrors();

    $news = News::first();
    expect($news->image)->not->toBeNull();
    Storage::disk('public')->assertExists($news->image);

    $this->assertDatabaseHas('news', [
        'title' => 'Berita Baru Desa',
        'excerpt' => 'Ringkasan berita',
    ]);
});

test('non-admin users cannot run manage content livewire actions', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('newsTitle', 'Berita Ilegal')
        ->set('newsExcerpt', 'Ringkasan')
        ->set('newsContent', 'Isi')
        ->call('saveNews')
        ->assertForbidden();

    expect(News::count())->toBe(0);
});

test('admin can update village statistics and upload hero image', function () {
    Storage::fake('public');
    $user = User::factory()->admin()->create();
    $stat = VillageStatistic::factory()->create(['label' => 'Hero Image', 'value' => 'initial-path']);
    $file = UploadedFile::fake()->image('hero.jpg');

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->call('editStat', $stat->id)
        ->set('heroImageUpload', $file)
        ->call('saveStat')
        ->assertHasNoErrors();

    $stat->refresh();
    expect($stat->value)->not->toBe('initial-path');
    Storage::disk('public')->assertExists($stat->value);
});

test('admin can create and edit apbdes items', function () {
    $user = User::factory()->admin()->create();

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('apbdesName', 'Dana Desa Tambahan')
        ->set('apbdesAmount', '100000000')
        ->set('apbdesCategory', 'pendapatan')
        ->call('saveApbdes')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('apbdes_items', [
        'name' => 'Dana Desa Tambahan',
        'amount' => 100000000,
    ]);
});

test('admin can manage apparatus and upload photo', function () {
    Storage::fake('public');
    $user = User::factory()->admin()->create();
    $file = UploadedFile::fake()->image('avatar.jpg');

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('appName', 'Budi Santoso')
        ->set('appPosition', 'Kepala Desa')
        ->set('appWelcomeMessage', 'Selamat datang baru')
        ->set('appImageUpload', $file)
        ->call('saveApp')
        ->assertHasNoErrors();

    $app = Apparatus::first();
    expect($app->image)->not->toBeNull();
    Storage::disk('public')->assertExists($app->image);
});

test('admin can manage galleries and upload image', function () {
    Storage::fake('public');
    $user = User::factory()->admin()->create();
    $file = UploadedFile::fake()->image('photo.jpg');

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('galTitle', 'Foto Baru Kegiatan')
        ->set('galImageUpload', $file)
        ->call('saveGal')
        ->assertHasNoErrors();

    $gal = Gallery::first();
    expect($gal->image)->not->toBeNull();
    Storage::disk('public')->assertExists($gal->image);
});

test('admin can manage potencies and upload image', function () {
    Storage::fake('public');
    $user = User::factory()->admin()->create();
    $file = UploadedFile::fake()->image('potency.jpg');

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('potTitle', 'UMKM Tempe Baru')
        ->set('potCategory', 'umkm')
        ->set('potDescription', 'UMKM Tempe Dalangan')
        ->set('potLatitude', '-7.250445')
        ->set('potLongitude', '112.768845')
        ->set('potImageUpload', $file)
        ->call('savePot')
        ->assertHasNoErrors();

    $pot = Potency::first();
    expect($pot->image)->not->toBeNull();
    Storage::disk('public')->assertExists($pot->image);
});

test('admin can create a facility potency point', function () {
    $user = User::factory()->admin()->create();

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->set('potTitle', 'Puskesmas Pembantu')
        ->set('potCategory', 'fasilitas')
        ->set('potDescription', 'Pusat layanan kesehatan desa')
        ->set('potLatitude', '-7.718')
        ->set('potLongitude', '110.813')
        ->call('savePot')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('potencies', [
        'title' => 'Puskesmas Pembantu',
        'category' => 'fasilitas',
    ]);
});
