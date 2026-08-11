<?php

use App\Models\PageView;
use App\Models\User;
use App\Models\Visitor;
use Livewire\Livewire;

test('visiting pages records page view hits', function () {
    $this->get(route('home'))->assertOk();
    $this->get(route('profil'))->assertOk();

    $this->assertDatabaseHas('page_views', [
        'ip_address' => '127.0.0.1',
        'path' => '/',
    ]);

    $this->assertDatabaseHas('page_views', [
        'ip_address' => '127.0.0.1',
        'path' => '/profil',
    ]);

    expect(PageView::count())->toBe(2);
});

test('admin can view analytics summary on manage content page', function () {
    $user = User::factory()->create();

    // Create mock visits & page views
    Visitor::factory()->count(3)->create(['visit_date' => now()->toDateString()]);
    PageView::factory()->count(10)->create(['created_at' => now()]);

    Livewire::actingAs($user)
        ->test('pages::manage-content')
        ->assertSet('totalHits', 10)
        ->assertSet('uniqueVisitors', 3)
        ->assertSet('popularPages', function ($pages) {
            return count($pages) > 0;
        })
        ->assertSet('chartData', function ($data) {
            return isset($data['labels']) && isset($data['visitors']) && isset($data['pageViews']);
        });
});

test('old page views can be pruned', function () {
    // Create page views (one fresh, one older than 30 days)
    $fresh = PageView::factory()->create(['created_at' => now()]);
    $old = PageView::factory()->create(['created_at' => now()->subDays(31)]);

    expect(PageView::count())->toBe(2);

    // Run the model prune command
    $this->artisan('model:prune', ['--model' => [PageView::class]]);

    expect(PageView::count())->toBe(1);
    $this->assertDatabaseHas('page_views', ['id' => $fresh->id]);
    $this->assertDatabaseMissing('page_views', ['id' => $old->id]);
});
