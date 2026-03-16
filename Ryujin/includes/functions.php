<?php
declare(strict_types = 1);

/**
 * Run a PDO query and return the statement object
 */
function pdo(PDO $pdo, string $sql, array $arguments = []): PDOStatement
{
    if (!$arguments) {                       // If no arguments
        return $pdo->query($sql);            // Run query and return PDOStatement
    }
    $statement = $pdo->prepare($sql);        // Prepare the query
    $statement->execute($arguments);         // Execute with arguments
    return $statement;                       // Return PDOStatement
}

/**
 * Escape HTML special characters to prevent XSS
 */
function html_escape(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Format a date string into a readable format
 */
function format_date(string $date): string
{
    return date('F j, Y', strtotime($date));
}

/**
 * Redirect to a URL with optional query string parameters
 */
function redirect(string $location, array $params = []): void
{
    $query = $params ? '?' . http_build_query($params) : '';
    header('Location: ' . $location . $query);
    exit;
}
