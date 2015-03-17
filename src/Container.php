<?php namespace Coreplex\Crumbs;

use Closure;
use Coreplex\Crumbs\Components\Crumb;
use Coreplex\Crumbs\Contracts\Crumb as CrumbContract;
use Coreplex\Crumbs\Contracts\Renderer as RendererContract;
use Coreplex\Crumbs\Contracts\Container as Contract;

class Container implements Contract {

    /**
     * The crumb implementation
     * 
     * @var Coreplex\Crumbs\Contracts\Crumb $crumb
     */
    protected $crumb;

    /**
     * The renderer implementation
     * 
     * @var Coreplex\Crumbs\Contracts\Renderer $renderer
     */
    protected $renderer;

    /**
     * The collection of breadcrumbs
     * 
     * @var array $crumbs
     */
    protected $crumbs;

    /**
     * The collection of preparations to be run on the container
     * 
     * @var array $preparations
     */
    protected $preparations = [];

    /**
     * Make a new crumbs instance
     * 
     * @return void
     */
    public function __construct(CrumbContract $crumb, RendererContract $renderer)
    {
        $this->crumbs = [];

        $this->crumb = $crumb;

        $this->renderer = $renderer;
    }

    /**
     * Add a new crumb
     * 
     * @param string $label
     * @param string $url
     * @param array $data
     */
    public function add($label, $url, $atEnd = true)
    {
        $crumb = $this->newCrumb();
        $crumb->setLabel($label);
        $crumb->setUrl($url);

        if ($atEnd) {
            array_push($this->crumbs, $crumb);
        } else {
            array_unshift($this->crumbs, $crumb);
        }
    }

    /**
     * Appends a new crumb to the container
     * 
     * @param  string $label
     * @param  string $url
     * @return void
     */
    public function append($label, $url)
    {
        $this->add($label, $url, true);
    }

    /**
     * Prepends a new crumb to the container
     * 
     * @param  string $label
     * @param  string $url
     * @return void
     */
    public function prepend($label, $url)
    {
        $this->add($label, $url, false);
    }

    /**
     * Add an anonymous function to prepare the breadcrumbs
     * 
     * @param  Closure $closure
     * @return $this
     */
    public function prepare(Closure $closure)
    {
        $this->addPreparation($closure);

        return $this;
    }

    /**
     * Return all crumbs
     * 
     * @return array
     */
    public function getCrumbs()
    {
        // Run any preparations before retrieving the crumbs
        $this->build();

        return $this->crumbs;
    }

    /**
     * Return how many crumbs are in the container
     * 
     * @return integer
     */
    public function count()
    {
        $this->build();

        return count($this->crumbs);
    }

    /**
     * Render the breadcrumbs
     * 
     * @return string
     */
    public function render($makeLastCrumbCurrent = true)
    {
        // Run any preparations before render
        $this->build();

        if ($this->count() > 0 && $makeLastCrumbCurrent) {
            $lastCrumb = array_pop($this->crumbs);

            $lastCrumb->setCurrent();

            array_push($this->crumbs, $lastCrumb);
        }

        return $this->renderer->render($this);
    }

    /**
     * Instantiates a new crumb
     * 
     * @return Coreplex\Crumbs\Contracts\Crumb;
     */
    protected function newCrumb()
    {
        return new $this->crumb;
    }

    /**
     * Run all non-run preparations before performing any information functions
     * 
     * @return void
     */
    protected function build()
    {
        foreach ($this->getPreparations() as $key => $preparation) {
            $preparation($this);
            unset($this->preparations[$key]);
        }
    }

    /**
     * Add a preparation closure to the crumbs instance
     * 
     * @param  Closure $closure
     * @return void
     */
    protected function addPreparation(Closure $closure)
    {
        $this->preparations[] = $closure;
    }

}