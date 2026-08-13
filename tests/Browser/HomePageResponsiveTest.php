<?php

use Database\Seeders\HomepageItemSeeder;
use Database\Seeders\HomepageSectionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('homepage remains within every supported viewport', function () {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);

    $page = visit('/');

    foreach ([280, 320, 336, 390, 768, 1024, 1440] as $width) {
        $page->resize($width, 900);

        expect($page->script('() => document.documentElement.scrollWidth'))
            ->toBe($width)
            ->and($page->script('() => Math.round(document.querySelector("#main-content").getBoundingClientRect().width)'))
            ->toBe($width)
            ->and($page->script('() => getComputedStyle(document.querySelector("#main-content")).transform'))
            ->toBe('none')
            ->and($page->script('() => Math.round(document.querySelector(".public-page-footer").getBoundingClientRect().width)'))
            ->toBe($width)
            ->and($page->script('() => [...document.querySelectorAll(".is-unavailable")].every((element) => getComputedStyle(element).display === "none")'))
            ->toBeTrue();
    }

    $page->assertNoJavaScriptErrors();
});

test('homepage fills a real mobile device viewport', function (string $device, int $width) {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);

    $page = visit('/')->on()->{$device}();

    $viewport = $page->script('() => {
        const main = document.querySelector("#main-content");
        const footer = document.querySelector(".public-page-footer");

        return {
            innerWidth: window.innerWidth,
            clientWidth: document.documentElement.clientWidth,
            scrollWidth: document.documentElement.scrollWidth,
            visualWidth: Math.round(window.visualViewport ? window.visualViewport.width : window.innerWidth),
            visualScale: window.visualViewport ? window.visualViewport.scale : 1,
            headerWidth: Math.round(document.querySelector("header").getBoundingClientRect().width),
            mainWidth: Math.round(main.getBoundingClientRect().width),
            mainLeft: Math.round(main.getBoundingClientRect().left),
            footerWidth: Math.round(footer.getBoundingClientRect().width),
            sectionsFillViewport: Array.from(main.children)
                .filter((section) => getComputedStyle(section).display !== "none")
                .every((section) => {
                const bounds = section.getBoundingClientRect();

                return Math.round(bounds.left) === 0 && Math.round(bounds.width) === window.innerWidth;
                }),
            viewportMeta: document.querySelector("meta[name=\"viewport\"]").content
        };
    }');

    expect($viewport['innerWidth'])
        ->toBe($width)
        ->and($viewport['clientWidth'])->toBe($width)
        ->and($viewport['scrollWidth'])->toBe($width)
        ->and($viewport['visualWidth'])->toBe($width)
        ->and($viewport['visualScale'])->toBe(1)
        ->and($viewport['headerWidth'])->toBe($width)
        ->and($viewport['mainWidth'])->toBe($width)
        ->and($viewport['mainLeft'])->toBe(0)
        ->and($viewport['footerWidth'])->toBe($width)
        ->and($viewport['sectionsFillViewport'])->toBeTrue()
        ->and($viewport['viewportMeta'])->toContain('minimum-scale=1');

    $page->assertNoJavaScriptErrors();
})->with([
    'iPhone SE' => ['iPhoneSE', 320],
    'Pixel 8' => ['pixel8', 412],
]);

test('news carousel pages like the teacher carousel on mobile', function () {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);

    $page = visit('/')->on()->iPhoneSE();
    $page->wait(1);

    expect($page->script('() => document.querySelectorAll("[data-news-slide]").length'))
        ->toBe(4)
        ->and($page->script('() => document.querySelector("[data-news-current]").textContent'))
        ->toBe('1')
        ->and($page->script('() => document.querySelector("[data-news-total]").textContent'))
        ->toBe('4')
        ->and($page->script('() => Math.round(document.querySelector("[data-news-slide]").getBoundingClientRect().width)'))
        ->toBe($page->script('() => Math.round(document.querySelector("[data-news-track]").getBoundingClientRect().width)'));

    expect($page->script('() => {
        document.querySelector("[data-news-carousel]").dispatchEvent(new Event("news:next"));

        return document.querySelector("[data-news-current]").textContent;
    }'))
        ->toBe('2')
        ->and($page->script('() => getComputedStyle(document.querySelector("[data-news-track]")).transform !== "none"'))
        ->toBeTrue();

    $page->assertNoJavaScriptErrors();
});

test('contact and footer remain readable and actionable on small phones', function () {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);

    $page = visit('/')->on()->iPhoneSE();

    $layout = $page->script('() => {
        const viewportWidth = document.documentElement.clientWidth;
        const contact = document.querySelector("[data-contact-card]");
        const footer = document.querySelector(".public-page-footer");
        const newsletter = document.querySelector("[data-footer-newsletter]");
        const newsletterInput = newsletter.querySelector("input");
        const newsletterButton = newsletter.querySelector("button");
        const contactActions = Array.from(contact.querySelectorAll(".contact-action"));
        const socialLinks = Array.from(footer.querySelectorAll(".footer-social"));

        return {
            contactWithinViewport: contact.getBoundingClientRect().right <= viewportWidth,
            footerWithinViewport: footer.getBoundingClientRect().right <= viewportWidth,
            navigationColumns: getComputedStyle(document.querySelector("[data-footer-navigation]")).gridTemplateColumns.split(" ").length,
            newsletterIsStacked: newsletterInput.getBoundingClientRect().top < newsletterButton.getBoundingClientRect().top,
            actionsAreTouchable: contactActions.every((action) => action.getBoundingClientRect().height >= 44),
            socialLinksAreTouchable: socialLinks.every((link) => link.getBoundingClientRect().height >= 44 && link.getBoundingClientRect().width >= 44),
            documentWidth: document.documentElement.scrollWidth
        };
    }');

    expect($layout['contactWithinViewport'])->toBeTrue()
        ->and($layout['footerWithinViewport'])->toBeTrue()
        ->and($layout['navigationColumns'])->toBe(2)
        ->and($layout['newsletterIsStacked'])->toBeTrue()
        ->and($layout['actionsAreTouchable'])->toBeTrue()
        ->and($layout['socialLinksAreTouchable'])->toBeTrue()
        ->and($layout['documentWidth'])->toBe(320);

    $page->assertNoJavaScriptErrors();
});
