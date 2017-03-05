<?php

class TweetRequester
{
    /**
     * @var TwitterClientInterface
     */
    protected $twitterClient;

    /**
     * @param $consumer_key
     * @param $consumer_secret
     */
    public function __construct($consumer_key, $consumer_secret)
    {
        $this->twitterClient = new TwitterOAuthWrapper($consumer_key, $consumer_secret);
    }

    /**
     * @param TwitterClientInterface $twitterClient
     */
    public function setTwitterClient(TwitterClientInterface $twitterClient)
    {
        $this->twitterClient = $twitterClient;
    }

    public function getLastTweets($screenName, $days = 1)
    {
        $dateSince = (new \DateTime())->modify('-' . $days . ' day')->format('Y-m-d');

        $searchParameters = new TwitterSearchParameters();
        $searchParameters->setSince($dateSince);
        $searchParameters->setFrom($screenName);

        $search = $this->search($searchParameters);

        return $this->buildTweets($search);
    }

    public function getResponses(Tweet $tweet)
    {
        $searchParameters = new TwitterSearchParameters();
        $searchParameters->setSinceId($tweet->getId());
        $searchParameters->setTo($tweet->getAuthor()->getScreenName());

        $search = $this->search($searchParameters);

        return $this->buildTweets($search);
    }

    public function getTweet($id)
    {
        $path = sprintf('statuses/show/%s', $id);
        $response = $this->twitterClient->get($path);

        return new Tweet($response);
    }

    protected function search(TwitterSearchParameters $searchParameters)
    {
        $path = 'search/tweets';
        $query = $searchParameters->toArray();
        $response = $this->twitterClient->get($path, $query);

        return $response;
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