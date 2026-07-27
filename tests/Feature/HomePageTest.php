<?php

test('the homepage presents the institute and its primary sections', function () {
    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Bangladesh National Youth Technical Institute')
        ->assertSee('images/bnyti-hero-premium-1.png', false)
        ->assertSee('images/bnyti-hero-premium-2.png', false)
        ->assertSee('images/bnyti-hero-premium-3.png', false)
        ->assertSee('data-hero-carousel', false)
        ->assertSee('Practical skills for a')
        ->assertSee('Learn the skills employers actually need.')
        ->assertSee('Student Services')
        ->assertSee('Opportunity, closer to home.')
        ->assertSee('data-theme-toggle', false)
        ->assertSee('data-locale-toggle', false)
        ->assertSee('id="mobile-menu"', false);
});
