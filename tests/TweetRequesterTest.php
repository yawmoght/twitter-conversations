<?php

class TweetRequesterTest extends PHPUnit_Framework_TestCase
{
    /** @var  TweetRequester|PHPUnit_Framework_MockObject_MockObject */
    protected $tweetRequester;

    /** @var  \Abraham\TwitterOAuth\TwitterOAuth|PHPUnit_Framework_MockObject_MockObject */
    protected $tweetClient;

    public function setUp()
    {
        $this->tweetRequester = new TweetRequester(TwitterConsumer::KEY, TwitterConsumer::SECRET);
    }

    /** @dataProvider getLastTweets */
    public function testGetLastTweets($screenName, $days, $apiResponse)
    {
        $response = $this->tweetRequester->getLastTweets($screenName, $days);
    }

    /** @dataProvider getResponses */
    public function testGetResponses($tweet)
    {
        $response = $this->tweetRequester->getResponses($tweet);
    }

    /** @dataProvider getTweet */
    public function testGetTweet($id)
    {
        $response = $this->tweetRequester->getTweet($id);
    }

    public function getLastTweets()
    {
        return array(
            array('yawmoght', 3, $this->getTestResponse()),
        );
    }

    public function getResponses()
    {

        return array(
            array($this->getCorrectTweet())
        );
    }

    public function getTweet()
    {
        return array(
            array('')
        );
    }

    protected function getCorrectTweet()
    {
        $tweet = new Tweet();
        $tweet->setId("");

        $twitterUser = new TwitterUser();
        $twitterUser->setScreenName('yawmoght');
        $tweet->setAuthor($twitterUser);

        return $tweet;
    }

    protected function getTestResponse()
    {
        $response = new \Abraham\TwitterOAuth\Response();

        $response->setHttpCode(200);

        return $response;
    }
}