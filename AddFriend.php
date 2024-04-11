<?php
session_start();

// Assuming $_SESSION['userId'] holds the ID of the currently logged-in user
$currentUser = $_SESSION['userId'];

// Placeholder for database connection
$db = new mysqli('host', 'username', 'password', 'database_name');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $friendUserId = $db->real_escape_string($_POST['userId']);
    
    // Rule checks
    if ($friendUserId == $currentUser) {
        $message = "You cannot send a friend request to yourself.";
    } elseif (!userIdExists($friendUserId, $db)) {
        $message = "The user ID does not exist.";
    } elseif (areAlreadyFriends($currentUser, $friendUserId, $db)) {
        $message = "You and the user are already friends.";
    } elseif (existingFriendRequest($currentUser, $friendUserId, $db)) {
        becomeFriends($currentUser, $friendUserId, $db);
        $message = "You are now friends with the user.";
    } else {
        sendFriendRequest($currentUser, $friendUserId, $db);
        $message = "Friend request sent.";
    }
}

function userIdExists($userId, $db) {
    // Implement the check if the user ID exists in the database
}

function areAlreadyFriends($currentUser, $friendUserId, $db) {
    // Implement the check for existing friendship
}

function existingFriendRequest($currentUser, $friendUserId, $db) {
    // Implement the check for existing friend request
}

function becomeFriends($currentUser, $friendUserId, $db) {
    // Implement becoming friends (insert into friends table)
}

function sendFriendRequest($currentUser, $friendUserId, $db) {
    // Implement sending a friend request (insert into friend requests table)
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Friend</title>
</head>
<body>
    <form method="post">
        Enter User ID to send a friend request: <input type="text" name="userId">
        <input type="submit" value="Send Friend Request">
    </form>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
</body>
</html>

