<?php

use App\Models\News;

test('anyone can visit a published news page', function () {
    $news = News::factory()->published()->create([
        'title' => 'Judul Berita Tes',
        'slug' => 'judul-berita-tes',
        'content' => 'Konten lengkap berita tes.',
    ]);

    $this->get(route('berita.show', $news->slug))
        ->assertOk()
        ->assertSee('Judul Berita Tes')
        ->assertSee('Konten lengkap berita tes.');
});

test('visitor gets 404 for non-existent news', function () {
    $this->get(route('berita.show', 'non-existent-news-slug'))
        ->assertNotFound();
});

test('visitor gets 404 for unpublished draft news', function () {
    $news = News::factory()->unpublished()->create([
        'title' => 'Berita Rahasia Draft',
        'slug' => 'berita-rahasia-draft',
    ]);

    $this->get(route('berita.show', $news->slug))
        ->assertNotFound();
});
