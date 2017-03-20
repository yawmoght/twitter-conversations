<?php

use Endpoints\AbstractEndpoint;

class TweetRequester
{
    /**
     * @var TwitterClientInterface
     */
    protected $twitterClient;

    protected $apiCalls = 0;

    /**
     * @param $consumer_key
     * @param $consumer_secret
     */
    public function __construct($consumer_key, $consumer_secret)
    {
        $this->twitterClient = new TwitterOAuthWrapper($consumer_key, $consumer_secret);
        $this->searchEndpoint = new \Endpoints\SearchEndpoint();
        $this->statusEndpoint = new \Endpoints\StatusEndpoint();
    }

    /**
     * @param TwitterClientInterface $twitterClient
     */
    public function setTwitterClient(TwitterClientInterface $twitterClient)
    {
        $this->twitterClient = $twitterClient;
    }

    public function getLastTweets($screenName, $daysAgo = 1)
    {
        $dateSince = $this->buildDateSince($daysAgo);

        return $this->getTweetsByDateRange($screenName, $dateSince);
    }

    protected function buildDateSince($daysAgo)
    {
        return (new \DateTime())->modify('-' . $daysAgo . ' day')->format('Y-m-d');
    }

    /**
     * @param $screenName
     * @param $dateSince
     * @param string $dateUntil
     * @return Tweet[]
     */
    public function getTweetsByDateRange($screenName, $dateSince, $dateUntil = 'now')
    {
        if ($dateUntil == 'now') {
            $dateUntil = $this->buildDateSince(-1);
        }

        $searchParameters = new TwitterSearchParameters();
        $searchParameters->setSince($dateSince);
        $searchParameters->setFrom($screenName);
        $searchParameters->setUntil($dateUntil);

        $search = $this->search($searchParameters);

        return $this->buildTweets($search);
    }

    public function getPossibleReplies(Tweet $tweet)
    {
        $searchParameters = new TwitterSearchParameters();
        $searchParameters->setSinceId($tweet->getId());
        $searchParameters->setTo($tweet->getAuthor()->getScreenName());

        $search = $this->search($searchParameters);

        return $this->buildTweets($search);
    }

    public function getTweet($id)
    {
        $this->statusEndpoint->setId($id);
        $response = $this->get($this->statusEndpoint, array());

        return new Tweet($response);
    }

    protected function search(TwitterSearchParameters $searchParameters)
    {
        $query = $searchParameters->toArray();

        $response = $this->get($this->searchEndpoint, $query);

        return $response;
    }

    protected function get(AbstractEndpoint $endpoint, $query = array())
    {
        $endpoint->addApiCallCount();
        $path = $endpoint->getPath();

        return $this->twitterClient->get($path, $query);
    }

    /**
     * @param $response
     * @return Tweet[]
     */
    protected function buildTweets($response)
    {
        $tweets = array();
        foreach ($response->statuses as $status) {
            $tweets[] = new Tweet($status);
        }

        return $tweets;
    }
}