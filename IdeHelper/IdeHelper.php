<?php 
namespace SoupIdeHelper\IdeHelper;

class IdeHelper
{
    protected $services = [];

    public function __constructor()
    {
        
    }

    public function getTemplate()
    {
        return '<?php
        namespace PHPSTORM_META {
            override(\Shopware\Components\DependencyInjection\Container::get(0), map([
                // bestätigt
                // debuglogger => \Shopware\Components\Logger::class,
                {{services}}
            ]));
        }
        ?>';
    }

    public function addService($service, $cls) 
    {
        $this->services[$service] = $cls;
    }

    public function parse()
    {
        $services = '';
        foreach($this->services as $id=>$cls) {
            $services .= $this->parseArrayLine($id, $cls);
        }
        $tpl = $this->getTemplate();
        $parsed = str_replace('{{services}}', $services, $tpl);
        return $parsed;
    }

    protected function parseArrayLine($id, $cls) 
    {
        return '"'.$id.'" => \\'.$cls.'::class,'."\n";
    }


}