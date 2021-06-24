<?php


namespace App\Controller;


class PostDTO
{
    private $id;

    private $title;

    private $content;

    private $datePost;

    private $mediaUrl;

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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDatePost()
    {
        return $this->datePost;
    }

    /**
     * @param mixed $datePost
     */
    public function setDatePost($datePost): void
    {
        $this->datePost = $datePost;
    }

    /**
     * @return mixed
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }

    /**
     * @param mixed $mediaUrl
     */
    public function setMediaUrl($mediaUrl): void
    {
        $this->mediaUrl = $mediaUrl;
    }

}