<?php
namespace Jb\ApiYahooWeatherBundle\Twig;

class ApiYahooWeatherTwigExtension extends \Twig_Extension {
    
    /** @var \Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService \Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService Object */
    protected $ApiYahooWeatherService;
    
    /**
     * @param \Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $ApiYahooWeatherService
     * @return void
     */
    public function __construct(\Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $ApiYahooWeatherService) {
        $this->ApiYahooWeatherService = $ApiYahooWeatherService;
    }
    
    /**
     * return custom functions for twig usage
     * @return type
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('jbAYW_get_temperature', array($this, 'getTemperature')),
            new \Twig_SimpleFunction('jbAYW_get_location', array($this, 'getLocation'))
        );
    }
    
    /**
     * Get temperature for twig usage
     * @param boolean $with_units return with unit or not
     * @return string
     */
    public function getTemperature($with_units=false){
        return $this->ApiYahooWeatherService->getTemperature($with_units);
    }
    
    /**
     * Get location for twig usage
     * @return string
     */
    public function getLocation(){
        return $this->ApiYahooWeatherService->getLocation();
    }
    
    /**
     * Get unique ID for this twig extension
     * @return string
     */
    public function getName()
    {
        return 'jb_api_yahoo_weather_extension';
    }
}
