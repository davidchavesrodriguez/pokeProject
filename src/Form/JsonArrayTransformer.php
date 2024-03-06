<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;

class JsonArrayTransformer implements DataTransformerInterface
{
    public function transform($value): ?string
    {
        if (null === $value) {
            return null;
        }

        return json_encode($value);
    }

    public function reverseTransform($value): ?array
    {
        if (null === $value) {
            return null;
        }

        return json_decode($value, true);
    }
}
