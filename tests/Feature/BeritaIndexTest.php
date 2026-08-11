<?php

use App\Models\News;

test('anyone can visit the news index page', function () {
    $this->get(route('berita.index'))
        ->assertOk()
        ->assertSee('Berita & Pengumuman', false);
});

test('news index page only shows published news', function () {
    $published = News::factory()->published()->create([
        'title' => 'Berita Publik',
        'slug' => 'berita-publik',
    ]);
    News::factory()->unpublished()->create([
        'title' => 'Berita Draft',
        'slug' => 'berita-draft',
    ]);

    $this->get(route('berita.index'))
        ->assertOk()
        ->assertSee('Berita Publik')
        ->assertDontSee('Berita Draft');
});

test('news index page links to the news detail page', function () {
    $news = News::factory()->published()->create([
        'title' => 'Berita Terhubung',
        'slug' => 'berita-terhubung',
    ]);

    $this->get(route('berita.index'))
        ->assertOk()
        ->assertSee(route('berita.show', $news->slug));
});
