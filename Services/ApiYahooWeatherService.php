<?php

namespace Jb\ApiYahooWeatherBundle\Services;

use Jb\ApiYahooWeather\Lib\ApiYahooWeather;

class ApiYahooWeatherService {
    
    /** @var \Jb\ApiYahooWeather\Lib\ApiYahooWeather $apiYahooWeatherObject */
    protected $apiYahooWeatherObject = null;
    
    /** @var null|\Aequasi\Bundle\CacheBundle\Service\CacheService $memcached Memcached service*/
    protected $memcached;
    
    /** @var integer $ttl ttl for the data in memcached */
    protected $ttl;
    
    /** @var string $env current environment */
    protected $env;
    
    /** @var string $lastInCache say if the last callApi is from memcached or not */
    protected $lastInCache = null;
    
    /** @var integer $woeid weoid code for the city you want (http://en.wikipedia.org/wiki/GeoPlanet) */
    protected $woeid;
    
    /** @var string $unit c or f for Celsius or Fahrenheit */
    protected $unit;

<<<<<<< HEAD
    /**
     * Constructor
     * 
     * @param integer $woeid weoid code for the city you want (http://en.wikipedia.org/wiki/GeoPlanet) 
     * @param string $unit c or f for Celsius or Fahrenheit 
     * @param \Aequasi\Bundle\CacheBundle\Service\CacheService $memcached memcached service
     * @param integer $ttl ttl for the data in memcached
     * @param string $env current environment
     * 
     * @return void
     */
=======
>>>>>>> 54a80174388619f151ab4548908c275f3166f5be
    public function __construct($woeid, $unit, \Aequasi\Bundle\CacheBundle\Service\CacheService $memcached = NULL, $ttl, $env) {
        $this->memcached = $memcached;
        $this->ttl = $ttl;
	$this->env = $env;

        $this->woeid = $woeid;
        $this->unit = $unit;
               
        $this->apiYahooWeatherObject = new ApiYahooWeather();
        if($woeid !== null){
            $this->callApi($woeid,$unit);
        }
    }

    /**
     * Call the Api from through the library
     * 
     * @param integer $woeid woeid of the city you want know the weather
     * @param string $unit c or f for Celsius or Fahrenheit
     * 
     * @return void
     */
    public function callApi($woeid,$unit=null) {
        $data = false;
	
	$key = $this->env.$woeid;

        if($this->memcached !== null){
            $data = $this->memcached->fetch($key);
        }
        if($data === false){
	    $this->apiYahooWeatherObject->callApi($woeid,($unit!==null)?$this->unit:$unit);
            if($this->memcached !== null){
                $this->lastInCache = "no";
                $this->memcached->save($key,$this->apiYahooWeatherObject->getLastResponse(),$this->ttl);
            }
        }else{
            $this->lastInCache = "yes";
            $this->apiYahooWeatherObject->setLastResponse($data);
        }
    }
    
    /**
     * get LastInCache
     * 
     * @return string
     */
    public function getLastIncache(){
        return $this->lastInCache;
    }
    
    /**
     * Get Last response from api call
     * 
     * @param boolean $toJson return array or string value
     * 
     * @return array|string
     */
    public function getLastResponse($toJson = false) {
        return $this->apiYahooWeatherObject->getLastResponse($toJson);
    }

    /**
     * Get temperature
     * 
     * @param boolean $with_unit return unit or not with temperature
     * 
     * @return string
     */
    public function getTemperature($with_unit = false) {
        return $this->apiYahooWeatherObject->getTemperature($with_unit);
    }
    
    /**
     * Get the Location
     * 
     * @return string
     */
    public function getLocation(){
        return $this->apiYahooWeatherObject->getLocation();
    }
    
    /**
     * Get the forecast
     * 
     * @return array
     */
    public function getForecast(){
        return $this->apiYahooWeatherObject->getForecast();
    }

}
