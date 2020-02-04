<?php

namespace SoupIdeHelper\Tests;

use SoupIdeHelper\SoupIdeHelper as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'SoupIdeHelper' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['SoupIdeHelper'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
