<?php

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

echo "Logged out successfully.";
