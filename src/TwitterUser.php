<?php

class TwitterUser
{
    protected $id;

    protected $screenName;

    protected $description;

    protected $profileImage;

    /**
     * TwitterUser constructor.
     * @param stdClass $userResponse
     */
    public function __construct(stdClass $userResponse = null)
    {
        if (null != $userResponse){
            $this->setResponse($userResponse);
        }
    }

    protected function setResponse(stdClass $userResponse)
    {
        $this->setId($userResponse->id);
        $this->setDescription($userResponse->description);
        $this->setScreenName($userResponse->screen_name);
        $this->setProfileImage($userResponse->profile_image_url);
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
     * @return mixed
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * @param mixed $screenName
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * @param mixed $profileImage
     */
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }


}