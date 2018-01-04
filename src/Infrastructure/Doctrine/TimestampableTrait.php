<?php


namespace App\Infrastructure\Doctrine;


trait TimestampableTrait
{
    /**
     * @var \Datetime|null
     */
    private $updatedAt;

    /**
     * @var \Datetime|null
     */
    private $createdAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt() : ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(?\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt() : ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(?\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}