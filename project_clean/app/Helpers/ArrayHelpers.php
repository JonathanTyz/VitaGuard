<?php

function check_array_keys(
    array $keys,
    array $data,
    string $context = 'Data'
): void {
    $missingFields = [];

    foreach ($keys as $field) {
        if (!array_key_exists($field, $data)) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        throw new InvalidArgumentException(
            "{$context} is missing required field(s): " .
            implode(', ', $missingFields)
        );
    }
}
