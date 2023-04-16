<?php

declare(strict_types=1);

namespace Sys\Application\Exception\Input;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class InputValidationFailedException extends ApplicationException
{
    /**
     * @var array<array-key, mixed>
     */
    public readonly array $violations;

    public function __construct(
        string $message,
        ConstraintViolationListInterface $violationList
    ) {
        $this->violations = $this->getViolations($violationList);

        parent::__construct($message);
    }

    /**
     * @return array<array-key, mixed>
     */
    private function getViolations(ConstraintViolationListInterface $violationList): array
    {
        $violations = [];
        foreach ($violationList as $violation) {
            $violations[] = [
                'description' => $violation->getMessage(),
                'property' => $violation->getPropertyPath(),
                'value' => $violation->getInvalidValue(),
            ];
        }

        return $violations;
    }
}
