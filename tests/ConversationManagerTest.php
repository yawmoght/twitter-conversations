<?php

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
        $this->conversationManager = new ConversationManager();
        $this->conversationManager->initiateClient(TwitterConsumer::KEY, TwitterConsumer::SECRET);

        $threads = $this->conversationManager->getThreads($screenName, $daysOld, $length);
    }

    protected function setUp()
    {
        $this->conversationManager = new ConversationManager();
        $this->conversationManager->initiateClient(TwitterConsumer::KEY, TwitterConsumer::SECRET);
    }

    public function getFirstTweet()
    {
        return array(
            array('', '', '')
        );
    }

    public function getThreads()
    {
        return array(
            array('', 1, 5)
        );
    }

}