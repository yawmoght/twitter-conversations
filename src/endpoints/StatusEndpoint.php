<?php

namespace Endpoints;

class StatusEndpoint extends AbstractEndpoint
{
    protected $path = 'statuses/show';

    protected $apiCallLimit = 900;

    public function buildPath($id = null)
    {
        return $this->path . '/' . $id;
    }

}