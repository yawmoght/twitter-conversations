<?php

interface TwitterClientInterface
{
    /**
     * @param string $path Path from Twitter API Documentation (e. g. search/tweets)
     * @param array $parameters query parameters
     * @return stdClass hydrated with twitter response
     */
    public function get($path, array $parameters = []);
}