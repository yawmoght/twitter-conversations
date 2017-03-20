<?php

class SearchParametersBuilder
{
    /**
     * @param $screenName
     * @param $dateSince
     * @param $dateUntil
     * @return TwitterSearchParameters
     */
    public function buildDateRange($screenName, $dateSince, $dateUntil)
    {
        $searchParameters = new TwitterSearchParameters();
        $searchParameters->setSince($dateSince);
        $searchParameters->setFrom($screenName);
        $searchParameters->setUntil($dateUntil);

        return $searchParameters;
    }

    /**
     * @param Tweet $tweet
     * @return TwitterSearchParameters
     */
    public function buildPossibleReplies(Tweet $tweet)
    {
        $searchParameters = new TwitterSearchParameters();
        $searchParameters->setSinceId($tweet->getId());
        $searchParameters->setTo($tweet->getAuthor()->getScreenName());

        return $searchParameters;
    }
}