<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="test.php" method="post">
        <label for="firstname">firstname</label><br>
        <input type="text" name="fname"><br>
        <label for="middlename">middlename</label><br>
        <input type="text" name="mname"><br>
        <label for="lastname">lastname</label><br>
        <input type="text" name="lname"><br>
        email<br><input type="email" name="email"><br>
        <input type="submit" value="submit">
    </form>

    <?php
echo $_POST["fname"],"<br>";
echo $_POST["mname"],"<br>";
echo $_POST["lnae"],"<br>";
echo $_POST["email"],"<br>";





    ?>
</body>
</html>