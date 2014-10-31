<?php
namespace Jb\ApiYahooWeatherBundle\Twig;

class ApiYahooWeatherTwigExtension extends \Twig_Extension {
    
    protected $ApiYahooWeatherService;
    
    public function __construct(\Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $ApiYahooWeatherService) {
        $this->ApiYahooWeatherService = $ApiYahooWeatherService;
    }
    
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('jbAYW_get_temperature', array($this, 'getTemperature')),
            new \Twig_SimpleFunction('jbAYW_get_location', array($this, 'getLocation'))
        );
    }
    
    public function getTemperature($with_units=false){
        return $this->ApiYahooWeatherService->getTemperature($with_units);
    }
    
    public function getLocation(){
        return $this->ApiYahooWeatherService->getLocation();
    }
    
    public function getName()
    {
        return 'jb_api_yahoo_weather_extension';
    }
}
