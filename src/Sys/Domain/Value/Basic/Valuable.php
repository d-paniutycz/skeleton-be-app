<?php

declare(strict_types=1);

namespace Sys\Domain\Value\Basic;

use JsonSerializable;

interface Valuable extends JsonSerializable
{
    public function getValue(): mixed;

    public function equals(Valuable $value): bool;
}
