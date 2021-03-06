<?php namespace Coreplex\Crumbs\Components;

use Coreplex\Crumbs\Contracts\Crumb as Contract;
use Exception;

class Crumb implements Contract {

    /**
     * The label of this breadcrumb
     * 
     * @var string
     */
    protected $label;

    /**
     * The URL of this breadcrumb
     * 
     * @var string
     */
    protected $url;

    /**
     * Whether or not this breadcrumb is the current location
     * 
     * @var boolean
     */
    protected $current = false;

    /**
     * Retrieve the breadcrumb label
     * 
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Retrieve the breadcrumb label
     * 
     * @return string
     */
    public function label()
    {
        return $this->getLabel();
    }

    /**
     * Whether or not this breadcrumb has a label
     * 
     * @return boolean
     */
    public function hasLabel()
    {
        $label = $this->getLabel();

        return ! empty($label);
    }

    /**
     * Retrieve the breadcrumb URL
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Retrieve the breadcrumb URL
     * 
     * @return string
     */
    public function url()
    {
        return $this->getUrl();
    }

    /**
     * Whether or not this breadcrumb has a URL
     * 
     * @return boolean
     */
    public function hasUrl()
    {
        $url = $this->getUrl();

        return ! empty($url);
    }

    /**
     * Set the label of the breadcrumb
     * 
     * @param  string $url
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the URL of the breadcrumb
     * 
     * @param  string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Retrieve whether or not the breadcrumb is the current one
     * 
     * @return boolean
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * Retrieve whether or not the breadcrumb is the current one
     * 
     * @return boolean
     */
    public function current()
    {
        return $this->isCurrent();
    }

    /**
     * Sets the breadcrumb to be the current location
     *
     * @return $this
     */
    public function setCurrent()
    {
        $this->current = true;

        return $this;
    }

    /**
     * Sets the breadcrumb to not be the current location
     * 
     * @return $this
     */
    public function setNotCurrent()
    {
        $this->current = false;

        return $this;
    }

}