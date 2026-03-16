<?php
// Troubleshooting helper for database connection
function db_troubleshoot($exception) {
    echo '<h2>Database Connection Error</h2>';
    echo '<pre>' . htmlspecialchars($exception->getMessage()) . '</pre>';
    echo '<p>Check your database settings in <code>includes/database-connection.php</code>.</p>';
    echo '<p>If you are using XAMPP, make sure MySQL is running and the database <b>ryujin</b> exists.</p>';
}
