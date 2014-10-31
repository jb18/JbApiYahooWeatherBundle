<?php
namespace Jb\ApiYahooWeatherBundle\Listeners;

class ApiYahooWeatherBundleListener {

    protected $apiYahooWeatherService;
    
    public function __construct(\Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $apiYahooWeatherService) {
        $this->apiYahooWeatherService = $apiYahooWeatherService;
    }
    
    public function onKernelResponse(\Symfony\Component\HttpKernel\Event\FilterResponseEvent $event){
        if($this->apiYahooWeatherService->getLastIncache()!== null){
            $event->getResponse()->headers->set('api-weather-hit-cache',$this->apiYahooWeatherService->getLastIncache());
        }
    }
    
}
