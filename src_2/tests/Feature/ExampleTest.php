<?php

declare(strict_types=1);

test('the root page redirects guests to login', function () {
    $response = $this->get('/');

    $response->assertRedirectToRoute('login');
});
