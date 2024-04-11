<?php
// Start the session and include necessary files
session_start();
include 'header.php'; // Make sure to use the correct path to your header file
// ... Include or require your database connection and necessary functions here

$currentUserId = $_SESSION['user_id']; // Replace with your session variable or method for getting the current user ID
// ... Load friends and friend requests from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Friends</title>
    <script>
        function confirmAction(action) {
            return confirm(`The selected friends will be ${action}!`);
        }
    </script>
    <!-- Add any additional CSS or JavaScript links here -->
</head>
<body>
    <div class="container">
        <h1>My Friends</h1>
        <p>Welcome Wei Gong! (not you? <a href="logout.php">change user here</a>)</p>
        <a href="AddFriend.php">Add Friends</a>

        <h2>Friends</h2>
        <form method="post" action="defriend.php" onsubmit="return confirmAction('defriended');">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Shared Albums</th>
                    <th>Defriend</th>
                </tr>
                <!-- Replace with actual friends data -->
                <?php foreach ($friends as $friend): ?>
                <tr>
                    <td><a href="view_friend_albums.php?id=<?php echo $friend['id']; ?>"><?php echo $friend['name']; ?></a></td>
                    <td><?php echo $friend['shared_albums_count']; ?></td>
                    <td><input type="checkbox" name="defriend[]" value="<?php echo $friend['id']; ?>"></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <input type="submit" value="Defriend Selected">
        </form>

        <h2>Friend Requests</h2>
        <form method="post" action="handle_friend_requests.php">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Accept or Deny</th>
                </tr>
                <!-- Replace with actual friend requests data -->
                <?php foreach ($friendRequests as $request): ?>
                <tr>
                    <td><?php echo $request['name']; ?></td>
                    <td><input type="checkbox" name="friend_request[]" value="<?php echo $request['id']; ?>"></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <input type="submit" name="action" value="Accept Selected" onclick="return confirmAction('accepted');">
            <input type="submit" name="action" value="Deny Selected" onclick="return confirmAction('denied');">
        </form>
    </div>

    <?php include 'footer.php'; // Make sure to use the correct path to your footer file ?>
</body>
</html>
