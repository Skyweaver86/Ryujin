<?php
declare(strict_types = 1);

/**
 * Check if a value is text within a given length range
 */
function is_text(?string $value, int $min, int $max): bool
{
    $length = mb_strlen($value ?? '');
    return ($length >= $min && $length <= $max);
}

/**
 * Check if a member_id exists in the authors array
 */
function is_member_id(mixed $id, array $authors): bool
{
    foreach ($authors as $author) {
        if ($author['id'] == $id) {
            return true;
        }
    }
    return false;
}

/**
 * Check if a category_id exists in the categories array
 */
function is_category_id(mixed $id, array $categories): bool
{
    foreach ($categories as $category) {
        if ($category['id'] == $id) {
            return true;
        }
    }
    return false;
}

/**
 * Create a safe unique filename for uploads
 */
function create_filename(string $filename, string $uploads): string
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $basename  = pathinfo($filename, PATHINFO_FILENAME);
    $basename  = preg_replace('/[^a-zA-Z0-9_-]/', '-', $basename);
    $name      = $basename . '.' . $extension;
    $i = 1;
    while (file_exists($uploads . $name)) {
        $name = $basename . '-' . $i . '.' . $extension;
        $i++;
    }
    return $name;
}