<?php
// Test 1: Empty Password
try {
    $pdo1 = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    echo "SUCCESS: Connected with EMPTY password!\n";
} catch (PDOException $e) {
    echo "FAILED with empty password: " . $e->getMessage() . "\n";
}

// Test 2: 'root' Password
try {
    $pdo2 = new PDO('mysql:host=127.0.0.1;port=3306', 'root', 'root');
    echo "SUCCESS: Connected with 'root' password!\n";
} catch (PDOException $e) {
    echo "FAILED with 'root' password: " . $e->getMessage() . "\n";
}
