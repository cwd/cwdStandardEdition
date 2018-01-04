<?php

/*
 * This file is part of Exceet Carrier Text Verwaltung
 *
 * (c) 2017 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User;

use App\Infrastructure\Doctrine\TimestampableTrait;
use FOS\UserBundle\Model\User as FOSUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User.
 */
class User extends FOSUser implements UserInterface
{
    use TimestampableTrait;

    protected $id;

    /**
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     */
    private $lastname;

    private $state;

    /**
     * @Assert\NotBlank(groups={"Create"})
     */
    protected $plainPassword;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    protected $email;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname(?string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname(?string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this|\FOS\UserBundle\Model\UserInterface|FOSUser
     */
    public function setEmail($email)
    {
        return parent::setEmail($email);
    }

    public function getFullname(): string
    {
        return sprintf('%s %s', $this->getFirstname(), $this->getLastname());
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return User
     */
    public function setState(?string $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState(): ?string
    {
        return $this->state;
    }
}
