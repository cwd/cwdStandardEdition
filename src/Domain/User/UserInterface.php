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

namespace App\Domain\User;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface extends AdvancedUserInterface
{
    public function getLastname(): ?string;

    public function getFirstname(): ?string;

    public function getCreatedAt(): ?\DateTime;

    public function getUpdatedAt(): ?\DateTime;
}
