<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Albums</title>






    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .align-center {
            align-items: center;
        }

        .add-link,
        .delete-link {
            text-decoration: none;
            color: #3498db;
            margin-left: 10px;
        }

        .margin-1 {
            margin: 10px 0;
        }

        .content-center {
            text-align: center;
        }
    </style>





</head>

<body>
    <?php
    // Start session and include necessary files
    session_start();
    include_once 'Project/db.php';
    include_once 'Project/Functions.php';

    // Set page title and validate user login
    setNewPageTitle('My Albums');
    validateUserLogin();

    // Fetching albums
    $userId = $_SESSION['user'];
    $albumsQuery = "SELECT Album.Album_Id, Album.Title, Album.Accessibility_Code, COUNT(Picture.Picture_Id) AS NumberOfPictures
                FROM Album
                LEFT JOIN Picture ON Album.Album_Id = Picture.Album_Id
                WHERE Album.Owner_Id = '$userId'
                GROUP BY Album.Album_Id, Album.Title, Album.Accessibility_Code";
    $result = $conn->query($albumsQuery);
    $albums = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $albums[] = $row;
        }
    }
    $getUserQuery = "SELECT Name FROM user WHERE UserId = '$userId'";
    $userQueryResult = $conn->query($getUserQuery);

    if ($userQueryResult->num_rows > 0) {
        $user = $userQueryResult->fetch_assoc();
        $userName = $user['Name'];
    }


    // Display error message if no albums are found
    if (count($albums) == 0) {
        notifyError('No albums added yet!');
    }

    // Fetching accessibility options
    $accessibilityOptions = [];
    $accessibilityQuery = "SELECT * FROM Accessibility";
    $result = $conn->query($accessibilityQuery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $accessibilityOptions[] = $row;
        }
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['albums'])) {
            $updatedAlbums = $_POST['albums'];
            foreach ($updatedAlbums as $albumId => $albumData) {
                $accessibility = $albumData['accessibility'];

                // Update album accessibility in the database
                $updateAlbumQuery = "UPDATE Album SET Accessibility_Code = '$accessibility' WHERE Album_Id = '$albumId'";
                $conn->query($updateAlbumQuery);
            }

            // Notify success and redirect to the same page
            notifySuccess('Changes saved successfully');
            header('Location: MyAlbums.php');
            exit();
        }
    }



    ?>

    <div class="flex justify-between align-center">
        <h1>My Albums</h1>
        <a class="add-link" href="AddAlbum.php">Create Album</a>
    </div>
    <span>Welcome <b><?php echo $userName; ?>!</span>
    <span>(Not you? Change user <a href="Logout.php">here</a>)</span>

    <?php displayUserNotification(); ?>

    <?php if (count($albums) > 0) : ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="table-container">
                <table>
                    <tr>
                        <th>Title</th>
                        <th>No. of Pictures</th>
                        <th>Accessibility</th>
                        <th></th>
                    </tr>
                    <?php foreach ($albums as $album) : ?>
                        <tr>
                            <td>
                                <a href="UploadPictures.php?album_id=<?php echo $album['Album_Id']; ?>">
                                    <?php echo $album['Title']; ?>
                                </a>
                            </td>
                            <td><?php echo $album['NumberOfPictures']; ?></td>
                            <td>
                                <select class="form-control" name="albums[<?php echo $album['Album_Id']; ?>][accessibility]">
                                    <?php foreach ($accessibilityOptions as $option) : ?>
                                        <option value="<?php echo $option['Accessibility_Code']; ?>" <?php echo ($album['Accessibility_Code'] === $option['Accessibility_Code']) ? 'selected' : ''; ?>>
                                            <?php echo $option['Description']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><a class="delete-link" href="AlbumDelete.php?album_id=<?php echo $album['Album_Id']; ?>" onclick="return confirm('Are you sure you want to delete this album?')">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="content-center margin-1">
                <div>
                    <input class="form-control" type="submit" value="Save changes" />
                </div>
            </div>
        </form>
    <?php endif; ?>

</div>



</body>

</html>