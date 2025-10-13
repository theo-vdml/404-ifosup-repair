<?php

test('welcome', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('about', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
    $response->assertSee('About Us');
});

test('contact', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
    $response->assertSee('Contact Us');
});
