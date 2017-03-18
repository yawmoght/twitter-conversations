<?php

use sensitive\TestData;
use sensitive\TwitterConsumer;

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
    public function testGetLastTweets($screenName, $days)
    {
        $response = $this->tweetRequester->getLastTweets($screenName, $days);
    }

    /** @dataProvider getTweetsByDateRange */
    public function testGetTweetsByDateRange($screenName, $dateSince, $dateUntil)
    {
        $response = $this->tweetRequester->getTweetsByDateRange($screenName, $dateSince, $dateUntil);
    }

    /** @dataProvider getReplies */
    public function testGetReplies($tweet)
    {
        $response = $this->tweetRequester->getReplies($tweet);
    }

    /** @dataProvider getTweet */
    public function testGetTweet($id)
    {
        $response = $this->tweetRequester->getTweet($id);
    }

    public function getLastTweets()
    {
        return array(
            array(TestData::ScreenName, 3),
        );
    }

    public function getTweetsByDateRange()
    {
        return array(
            array(TestData::ScreenName, TestData::DateSinceNow, 'now'),
            array(TestData::ScreenName, TestData::DateSince, TestData::DateUntil)
        );
    }

    public function getReplies()
    {
        return array(
            array($this->getCorrectTweet())
        );
    }

    public function getTweet()
    {
        return array(
            array(TestData::TwitterIdForReplies)
        );
    }

    protected function getCorrectTweet()
    {
        $tweet = new Tweet();
        $tweet->setId(TestData::TwitterIdForReplies);

        $twitterUser = new TwitterUser();
        $twitterUser->setScreenName(TestData::ScreenName);
        $tweet->setAuthor($twitterUser);

        return $tweet;
    }
}