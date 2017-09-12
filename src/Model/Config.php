<?php

namespace Mmo\OVHClient\Model;

class Config
{
    protected $application_key;
    protected $application_secret;
    protected $api_endpoint;
    protected $consumer_key;

    /**
     * @return string
     */
    public function getApplicationKey()
    {
        return $this->application_key;
    }

    /**
     * @param string $application_key
     */
    public function setApplicationKey($application_key)
    {
        $this->application_key = $application_key;
    }

    /**
     * @return string
     */
    public function getApplicationSecret()
    {
        return $this->application_secret;
    }

    /**
     * @param string $application_secret
     */
    public function setApplicationSecret($application_secret)
    {
        $this->application_secret = $application_secret;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->api_endpoint;
    }

    /**
     * @param string $api_endpoint
     */
    public function setApiEndpoint($api_endpoint)
    {
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * @return string
     */
    public function getConsumerKey()
    {
        return $this->consumer_key;
    }

    /**
     * @param string $consumer_key
     */
    public function setConsumerKey($consumer_key)
    {
        $this->consumer_key = $consumer_key;
    }
}