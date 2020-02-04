<?php

namespace SoupIdeHelper\Commands;

use Shopware\Components\Model\ModelManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Shopware\Commands\ShopwareCommand;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class IdeHelper extends ShopwareCommand
{
    /** @var \SoupIdeHelper\IdeHelper\IdeHelper $ideHelper */
    protected $ideHelper;
    
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ideHelper = new \SoupIdeHelper\IdeHelper\IdeHelper();

        $this
            ->setName('soup:idehelper:build')
            ->setDescription('Build IDEHelper File')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                "set an additional name, path is also possible 
                \ndefault: phpstorm.meta.php
                \n
                \nexample: phpstorm.meta.php/shopware.meta.php
                \nexample: foobar/phpstorm.meta.php
                \nexample: phpstorm.meta.php"
            )
            // ->addOption(
            //     'name',
            //     null,
            //     InputOption::VALUE_OPTIONAL,
            //     'An optional *option*',
            //     'My-Default-Value'
            // )
            ->setHelp(<<<EOF
The <info>%command.name%</info> implements a command.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = Shopware()->Container();
        $serviceIds = $container->getServiceIds();
        $failed = [];
        $dontParse = [
            'shopware.cart.net_rounding',
        ];


        foreach($serviceIds as $id) {
            try {
                if(!in_array($id, $dontParse)) {
                    $service = $container->get($id);
                    $this->ideHelper->addService($id, get_class($service));
                }
            } catch(ServiceNotFoundException $error) {
                // collect all id´s wich had errors
                $failed[] = $id;
            }
        }
        $this->writeFile($input);
        
        if(count($failed) || count($dontParse)) {
            $output->writeln('some services where not exported');
            $output->write(implode(', ', $dontParse));
            echo ' ,';
            $output->write(implode(', ', $failed));
        }
    }

    protected function writeFile(InputInterface $input)
    {
        $path = Shopware()->DocPath();

        $filename = $input->getArgument('name');
        if(!$filename) {
            $filename = 'phpstorm.meta.php';
        }
        $filePath = $path . $filename;
        $content = $this->ideHelper->parse();
        file_put_contents($filePath, $content);  
    }
}
