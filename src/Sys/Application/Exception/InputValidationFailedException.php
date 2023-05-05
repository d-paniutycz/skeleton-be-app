<?php

declare(strict_types=1);

namespace Sys\Application\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class InputValidationFailedException extends ApplicationException
{
    public readonly array $violations;

    public function __construct(string $message, ConstraintViolationListInterface $violationList)
    {
        $this->violations = $this->getViolations($violationList);

        parent::__construct($message);
    }

    private function getViolations(ConstraintViolationListInterface $violationList): array
    {
        $violations = [];
        foreach ($violationList as $violation) {
            $code = $violation->getCode();

            $violations[] = [
                'type' => is_null($code) ? null : 'urn:uuid:' . $code,
                'detail' => $violation->getMessage(),
                'additional' => [
                    'property' => $violation->getPropertyPath(),
                    'value' => $violation->getInvalidValue(),
                ],
            ];
        }

        return $violations;
    }
}
