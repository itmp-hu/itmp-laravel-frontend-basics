<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Users</h1>
    <ul>
        <?php
        foreach ($users as $user) {
            echo "<li>$user->name</li>";
        }
        ?>
    </ul>
</body>

</html>