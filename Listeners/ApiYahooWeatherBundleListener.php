<?php
namespace Jb\ApiYahooWeatherBundle\Listeners;

class ApiYahooWeatherBundleListener {
    
    /** @var \Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $apiYahooWeatherService ApiYahooWeatherService object*/
    protected $apiYahooWeatherService;
    
    /**
     * @param \Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $apiYahooWeatherService
     */
    public function __construct(\Jb\ApiYahooWeatherBundle\Services\ApiYahooWeatherService $apiYahooWeatherService) {
        $this->apiYahooWeatherService = $apiYahooWeatherService;
    }
    
    /**
     * Listener on Kernel.response event - Put new header to know if weather is from cache or not
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     * @return void
     */
    public function onKernelResponse(\Symfony\Component\HttpKernel\Event\FilterResponseEvent $event){
        if($this->apiYahooWeatherService->getLastIncache()!== null){
            $event->getResponse()->headers->set('api-weather-hit-cache',$this->apiYahooWeatherService->getLastIncache());
        }
    }
    
}
