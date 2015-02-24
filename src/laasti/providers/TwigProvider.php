<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Providers;

use League\Container\ServiceProvider;

/**
 * Description of WhoopsProvider
 *
 * @author Sonia
 */
class TwigProvider extends ServiceProvider
{

    protected $provides = [
        'Laasti\TwigRenderer',
        'Twig_LoaderInterface',
    ];

    public function register()
    {
        $c = $this->getContainer();
        if (!$c->isRegistered('Twig_LoaderInterface')) {
            $c->add('Twig_LoaderInterface', function() {
                //TODO: Have a way to set configurations
                //Maybe use the Environment service, to request a configuration?
                //Environment->get('templates_folder')
                $loader = new \Twig_Loader_Filesystem(__DIR__.'/../../../resources/views');
                return $loader;
            });
        }
        
        //TODO: Should provide an interface instead so we can swap if we need to
        $c->add('Laasti\TwigRenderer', function() use ($c) {
            $loader = $c->get('Twig_LoaderInterface');
            $twig = new \Twig_Environment($loader);
            /*
            $twig->getLoader()->addPath($path, 'namespace');
            $twig->render('@namespace/index.html');
            */
            return new \Laasti\TwigRenderer($twig);
        }, true);
    }

}
