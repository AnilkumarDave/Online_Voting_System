<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page in admin folder
header("Location: /Online_Voting_System/admin/index.php");
exit();
?>
