<?php

class TwitterSearchParameters
{
    protected $from;

    protected $to;

    protected $since;

    protected $until;

    protected $count = 100;

    protected $since_id;

    protected $queryStrings = array();

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getSince()
    {
        return $this->since;
    }

    /**
     * @param mixed $since
     */
    public function setSince($since)
    {
        $this->since = $since;
    }

    /**
     * @return mixed
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @param mixed $until
     */
    public function setUntil($until)
    {
        $this->until = $until;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getSinceId()
    {
        return $this->since_id;
    }

    /**
     * @param mixed $since_id
     */
    public function setSinceId($since_id)
    {
        $this->since_id = $since_id;
    }

    public function toArray()
    {
        $string = $this->buildQueryString();

        $return = array(
            'q' => $string,
            'count' => $this->getCount(),
        );

        if ($this->getSinceId()){
            $return['since_id'] = $this->getSinceId();
        }

        return $return;
    }

    protected function buildQueryString()
    {
        $this->addQueryPart($this->getFrom(), 'from');
        $this->addQueryPart($this->getTo(), 'to');
        $this->addQueryPart($this->getSince(), 'since');
        $this->addQueryPart($this->getUntil(), 'until');
//        $this->addQueryPart($this->getSinceId(), 'since_id');

        return implode(' ', $this->queryStrings);
    }

    protected function addQueryPart($value, $name)
    {
        if (null !== $value) {
            $this->queryStrings[] = $name . ':' . $value;
        }
    }
}