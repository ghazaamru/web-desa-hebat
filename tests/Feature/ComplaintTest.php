<?php

use App\Models\Complaint;
use App\Models\User;
use Livewire\Livewire;

test('anyone can visit the complaint submission page', function () {
    $this->get(route('pengaduan.create'))
        ->assertOk()
        ->assertSee('Layanan Pengaduan');
});

test('visitor can submit a complaint successfully', function () {
    Livewire::test('pages::pengaduan')
        ->set('name', 'Budi Raharjo')
        ->set('phone', '08123456789')
        ->set('subject', 'Jalan Rusak')
        ->set('content', 'Jalan di depan masjid rusak parah.')
        ->call('submitComplaint')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    $this->assertDatabaseHas('complaints', [
        'name' => 'Budi Raharjo',
        'phone' => '08123456789',
        'subject' => 'Jalan Rusak',
        'status' => 'pending',
    ]);
});

test('complaint submission validation is enforced', function () {
    Livewire::test('pages::pengaduan')
        ->call('submitComplaint')
        ->assertHasErrors(['name', 'phone', 'subject', 'content']);
});

test('bot submissions caught by honeypot are silently ignored', function () {
    Livewire::test('pages::pengaduan')
        ->set('name', 'Bot')
        ->set('phone', '08123456789')
        ->set('subject', 'Spam')
        ->set('content', 'Isi spam panjang untuk menguji honeypot')
        ->set('website', 'http://spam.example.com')
        ->call('submitComplaint')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    expect(Complaint::count())->toBe(0);
});

test('complaint submissions are rate limited', function () {
    foreach (range(1, 3) as $i) {
        Livewire::test('pages::pengaduan')
            ->set('name', "Warga {$i}")
            ->set('phone', '08123456789')
            ->set('subject', 'Subjek')
            ->set('content', 'Isi aduan yang cukup panjang')
            ->call('submitComplaint')
            ->assertHasNoErrors();
    }

    Livewire::test('pages::pengaduan')
        ->set('name', 'Warga Keempat')
        ->set('phone', '08123456789')
        ->set('subject', 'Subjek')
        ->set('content', 'Isi aduan yang cukup panjang')
        ->call('submitComplaint')
        ->assertHasNoErrors();

    expect(Complaint::count())->toBe(3);
});

test('admin can view and moderate complaints on manage content page', function () {
    $user = User::factory()->admin()->create();
    $complaint = Complaint::factory()->pending()->create([
        'name' => 'Ahmad',
        'subject' => 'Sampah Menumpuk',
    ]);

    // View complaints list
    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->assertSee($complaint->name)
        ->assertSee($complaint->subject);

    // Open detail modal and change status
    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->call('viewComplaint', $complaint->id)
        ->assertSet('compStatus', 'pending')
        ->set('compStatus', 'processed')
        ->call('updateComplaintStatus')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('complaints', [
        'id' => $complaint->id,
        'status' => 'processed',
    ]);

    // Delete complaint
    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->call('deleteComplaint', $complaint->id)
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('complaints', [
        'id' => $complaint->id,
    ]);
});
