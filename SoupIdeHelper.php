<?php

namespace SoupIdeHelper;

use Shopware\Components\Plugin;
use Shopware\Components\Console\Application;
use SoupIdeHelper\Commands\IdeHelper;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin SoupIdeHelper.
 */
class SoupIdeHelper extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('soup_ide_helper.plugin_dir', $this->getPath());
        parent::build($container);
    }

}
