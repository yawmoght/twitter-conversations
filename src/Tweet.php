<?php

class Tweet
{
    protected $id;

    /**
     * @var TwitterUser
     */
    protected $author;

    protected $text;

    /**
     * @var Tweet[]
     */
    protected $replies = array();

    protected $reply_to;

    /**
     * Tweet constructor.
     * @param stdClass $status
     */
    public function __construct(stdClass $status = null)
    {
        if (null !== $status){
            $this->setStatus($status);
        }
    }

    public function setStatus(stdClass $status)
    {
        $author = new TwitterUser($status->user);
        $this->setAuthor($author);
        $this->setId($status->id);
        $this->setText($status->text);
        $this->setReplyTo($status->in_reply_to_status_id);
    }

    public static function buildFromStatusUrl($url)
    {
        $parts = parse_url($url);

        $path = explode('/', $parts['path']);

        $tweet = new static();
        $author = new TwitterUser();
        $author->setScreenName($path[1]);
        $tweet->setAuthor($author);
        $tweet->setId($path[3]);

        return $tweet;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return TwitterUser
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return Tweet[]
     */
    public function getReplies()
    {
        return $this->replies;
    }

    public function addReply(Tweet $tweet)
    {
        $this->replies[$tweet->getId()] = $tweet;
    }

    /**
     * @return mixed
     */
    public function getReplyTo()
    {
        return $this->reply_to;
    }

    public function isReply()
    {
        return !!$this->reply_to;
    }

    /**
     * @param mixed $reply_to
     */
    public function setReplyTo($reply_to)
    {
        $this->reply_to = $reply_to;
    }

    public function getThreadLength()
    {
        foreach ($this->getReplies() as $reply){
            if ($reply->getAuthor()->getScreenName() == $this->getAuthor()->getScreenName()){
                return $reply->getThreadLength() + 1 ;
            }
        }

        return 1;
    }
}