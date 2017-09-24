<?php

/*
 * This file is part of Application.
 *
 * (c) 2017 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\User\UserInterface;
use Cwd\CommonBundle\Doctrine\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Domain\User\UserRepository")
 *
 * @UniqueEntity(fields={"email"}, groups={"create"})
 */
class User extends FOSUser implements UserInterface
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $state;

    /**
     * @Assert\NotBlank
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
