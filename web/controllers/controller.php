<?php
/**
 * Controlador principal
 */
namespace Rogue\Controllers;

use Spot\Locator;
use Twig_Environment;

class Controller{

    /**
     * Twig injection
     * @var object
     */
    protected $twig;

    /**
     * Spot Locator injection
     * @var object
     */
    protected $spot;

    /**
     * Controller constructor.
     * @param Twig_Environment $twig
     * @param \Spot\Locator $spot
     */
    public function __construct(Twig_Environment $twig, Locator $spot)
    {
        $this->twig = $twig;
        $this->spot = $spot;
    }

    public function list($vars,$request){
        dump($vars);
    }

    public function edit($vars,$request){
        dump($vars);
    }

    public function delete($vars,$request){
        dump($vars);
    }

}