<?php

uses(Tests\TestCase::class)->in('Feature', 'Unit');

test('the application redirects to login page', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
    $response->assertRedirect('/auth/login');
});
