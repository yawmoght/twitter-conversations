<?php

class ConversationManager
{
    /** @var  TweetRequester */
    protected $tweetRequester;

    /**
     * @return mixed
     */
    public function getTweetRequester()
    {
        return $this->tweetRequester;
    }

    public function initiateClient($key, $secret)
    {
        $this->tweetRequester = new TweetRequester($key, $secret);
    }

    /**
     * From a given tweet, request Twitter API to get to the first tweet of the conversation
     * @param Tweet $tweet
     * @return Tweet
     */
    public function getFirstTweet(Tweet $tweet)
    {
        if ($previousTweetId = $tweet->getReplyTo()) {
            $previousTweet = $this->tweetRequester->getTweet($previousTweetId);
            $previousTweet->addReply($tweet);

            return $this->getFirstTweet($previousTweet);
        }

        return $tweet;
    }

    /**
     * From some tweets, if they are replies of each other, they are put in order and removed duplicates
     * @param Tweet[] $tweets
     */
    public function relateTweets(array &$tweets)
    {
        foreach ($tweets as $replyKey => $possibleReply) {
            foreach ($tweets as $possibleMain) {
                if ($possibleReply->isReply() && $possibleReply->getReplyTo() == $possibleMain->getId()) {
                    $possibleMain->addReply($possibleReply);
                    unset($tweets[$replyKey]);
                }
            }
        }
    }

    /**
     * @param $screenName
     * @param int $daysOld
     * @param int $length
     * @return Tweet[]
     */
    public function getThreads($screenName, $daysOld = 1, $length = 5)
    {
        $tweets = $this->getConversations($screenName, $daysOld);
        $this->filterThreads($tweets, $length);

        return $tweets;
    }

    /**
     * @param $screenName
     * @param $daysOld
     * @return Tweet[]
     */
    private function getConversations($screenName, $daysOld)
    {
        $tweets = $this->tweetRequester->getLastTweets($screenName, $daysOld);
        $this->relateTweets($tweets);

        return $tweets;
    }

    /**
     * @param Tweet[] $tweets
     * @param $length
     */
    protected function filterThreads(array &$tweets, $length)
    {
        foreach ($tweets as $key => $tweet) {
            if ($tweet->getThreadLength() < $length)
            {
                unset($tweets[$key]);
            }
        }
    }


}