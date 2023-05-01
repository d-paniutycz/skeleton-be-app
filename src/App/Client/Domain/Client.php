<?php

declare(strict_types=1);

namespace App\Client\Domain;

use App\Client\Domain\Value\ClientEmail;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    #[ORM\Embedded(columnPrefix: false)]
    private readonly ClientId $id;

    #[ORM\Embedded(columnPrefix: false)]
    private ClientEmail $email;

    #[ORM\Embedded(columnPrefix: false)]
    private ClientPassword $password;

    public function __construct(
        ClientId $id,
        ClientEmail $email,
        ClientPassword $password,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getEmail(): ClientEmail
    {
        return $this->email;
    }

    public function getPassword(): ClientPassword
    {
        return $this->password;
    }
}
