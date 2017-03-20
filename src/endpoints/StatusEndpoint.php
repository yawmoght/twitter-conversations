<?php

namespace Endpoints;

class StatusEndpoint extends AbstractEndpoint
{
    protected $path = 'statuses/show/%s';

    protected $apiCallLimit = 900;

    protected $id = '';

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getPath()
    {
        return sprintf($this->path, $this->id);
    }

}