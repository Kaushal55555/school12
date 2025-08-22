<?php

require __DIR__.'/vendor/autoload.php';

// Test file writing
file_put_contents('test_output.txt', 'Test script is running');

echo "Test script executed successfully. Check test_output.txt for output.\n";
