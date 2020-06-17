<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ListAllBooksControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function __invoke_pageShouldLoadCorrectly()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSame(
            3,
            $crawler->filter('a.list-group-item')->count()
        );

        $this->assertStringContainsString(
            ucwords('children'),
            $crawler->filter('a.list-group-item')->eq(0)->text()
        );

        $this->assertStringContainsString(
            ucwords('fiction'),
            $crawler->filter('a.list-group-item')->eq(1)->text()
        );

        $this->assertStringContainsString(
            '0.00',
            $crawler->filter('span.js-cart-total')->eq(0)->text()
        );

        $this->assertStringContainsString(
            '0',
            $crawler->filter('span.js-cart-quantity')->eq(0)->text()
        );
    }
}
