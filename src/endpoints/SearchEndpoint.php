<?php

namespace Endpoints;

class SearchEndpoint extends AbstractEndpoint
{
    protected $path = 'search/tweets';

    protected $apiCallLimit = 450;
}