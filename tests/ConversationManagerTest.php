<?php

use sensitive\TwitterConsumer;
use sensitive\TestData;

class ConversationManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConversationManager
     */
    protected $conversationManager;

    /** @dataProvider getFirstTweet */
    public function testGetFirstTweet($id, $replies_to, $screenName)
    {
        $tweet = new Tweet();
        $tweet->setId($id);
        $tweet->setReplyTo($replies_to);
        $tweetAuthor = new TwitterUser();
        $tweetAuthor->setScreenName($screenName);
        $tweet->setAuthor($tweetAuthor);

        $topTweet = $this->conversationManager->getFirstTweet($tweet);
    }

    /** @dataProvider getThreads */
    public function testGetThreads($screenName, $daysOld, $length)
    {
        $threads = $this->conversationManager->getThreads($screenName, $daysOld, $length);
    }

    /** @dataProvider fillConversation */
    public function testFillConversation($tweetUrl)
    {
        $tweet = Tweet::buildFromStatusUrl($tweetUrl);

        $this->conversationManager->fillConversation($tweet);
    }

    protected function setUp()
    {
        $this->conversationManager = new ConversationManager();
        $this->conversationManager->initiateClient(TwitterConsumer::KEY, TwitterConsumer::SECRET);
    }

    public function getFirstTweet()
    {
        return array(
            array(TestData::TwitterIdForFirstReply, TestData::RepliesToForFirstReply, TestData::ScreenName)
        );
    }

    public function getThreads()
    {
        return array(
            array(TestData::ScreenName, 1, 5)
        );
    }

    public function fillConversation()
    {
        return array(
            array(TestData::FillConversationUrl)
        );
    }

}