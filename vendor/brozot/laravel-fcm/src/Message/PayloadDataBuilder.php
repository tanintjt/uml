<?php

namespace LaravelFCM\Message;

/**
 * Class PayloadDataBuilder.
 *
 * Official google documentation :
 *
 * @link http://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
 */
class PayloadDataBuilder
{
    /**
     * @internal
     *
     * @var array
     */
    protected $data;
    protected $title;
    protected $body;

    /**
     * add data to existing data.
     *
     * @param array $data
     *
     * @return PayloadDataBuilder
     */
    public function addData(array $data)
    {
        $this->data = $this->data ?: [];

        $this->data = array_merge($data, $this->data);

        return $this;
    }

    public function addTitle($title)
    {
        $this->title = $this->title ?: [];

        $this->title = array_merge($title, $this->title);

        return $this;
    }

    public function addBody($body)
    {
        $this->body = $this->body ?: [];

        $this->body = array_merge($body, $this->body);

        return $this;
    }




    public function setClickAction($action)
    {
        $this->clickAction = $action;

        return $this;
    }


    /**
     * erase data with new data.
     *
     * @param array $data
     *
     * @return PayloadDataBuilder
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function setTitle(array $title)
    {
        $this->title = $title;

        return $this;
    }


    public function setBody(array $body)
    {
        $this->body = $body;

        return $this;
    }
    /**
     * Remove all data.
     */
    public function removeAllData()
    {
        $this->data = null;
    }

    /**
     * return data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }
    /**
     * generate a PayloadData.
     *
     * @return PayloadData new PayloadData instance
     */
    public function build()
    {
        return new PayloadData($this);
    }
}
