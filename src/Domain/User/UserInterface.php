<?php
/**
 * Created by PhpStorm.
 * User: ludwig
 * Date: 24.09.17
 * Time: 11:24
 */

namespace App\Domain\User;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface extends  AdvancedUserInterface
{
    public function getLastname() : ?string;
    public function getFirstname() : ?string;
    public function getCreatedAt() : ?\DateTime;
    public function getUpdatedAt() : ?\DateTime;
}