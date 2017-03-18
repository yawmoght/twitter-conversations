<?php

namespace Endpoints;

class AbstractEndpoint
{
    protected $path;

    protected $apiCallsCount;

    protected $apiCallLimit;

    /**
     * @return mixed
     */
    public function getApiCallsCount()
    {
        return $this->apiCallsCount;
    }

    /**
     * @param mixed $apiCallsCount
     */
    public function setApiCallsCount($apiCallsCount)
    {
        $this->apiCallsCount = $apiCallsCount;
    }

    public function addApiCallCount($count = 1)
    {
        $this->apiCallsCount += $count;
    }

    /**
     * @return mixed
     */
    public function getApiCallLimit()
    {
        return $this->apiCallLimit;
    }

    public function buildPath($id = null)
    {
        return $this->path;
    }

}