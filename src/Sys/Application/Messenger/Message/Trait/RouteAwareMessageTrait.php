<?php

namespace Sys\Application\Messenger\Message\Trait;

trait RouteAwareMessageTrait
{
    private bool $async = false;

    private bool $held = false;

    public function isAsync(): bool
    {
        return $this->async;
    }

    public function sendAsync(bool $async): static
    {
        $this->async = $async;

        if ($async) {
            $this->held = true;
        }

        return $this;
    }

    public function isHeld(): bool
    {
        return $this->held;
    }

    public function sendHeld(bool $held): static
    {
        $this->held = $held;

        return $this;
    }
}
