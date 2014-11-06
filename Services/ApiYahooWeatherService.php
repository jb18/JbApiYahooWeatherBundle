<?php

namespace Jb\ApiYahooWeatherBundle\Services;

use Jb\ApiYahooWeather\Lib\ApiYahooWeather;

class ApiYahooWeatherService {
    
    protected $apiYahooWeatherObject = null;
    protected $memcached = null;
    protected $ttl;
    protected $env;
    protected $lastInCache = null;
    
    protected $woeid;
    protected $unit;

    public function __construct($woeid, $unit, $memcached, $ttl, $env) {
        
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
    
    public function getLastIncache(){
        return $this->lastInCache;
    }

    public function getLastResponse($toJson = false) {
        return $this->apiYahooWeatherObject->getLastResponse($toJson);
    }

    public function getTemperature($with_unit = false) {
        return $this->apiYahooWeatherObject->getTemperature($with_unit);
    }
    
    public function getLocation(){
        return $this->apiYahooWeatherObject->getLocation();
    }
    
    public function getForecast(){
        return $this->apiYahooWeatherObject->getForecast();
    }

}
