<?php
$MySQL = mysqli_connect("localhost", "root", "", "vjezba16") or die('Error connecting to MySQL server.');

$query = "SELECT * FROM countries";
$result = mysqli_query($MySQL, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysqli_real_escape_string($MySQL, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($MySQL, $_POST['lastname']);
    $email = mysqli_real_escape_string($MySQL, $_POST['email']);
    $username = mysqli_real_escape_string($MySQL, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $country_id = mysqli_real_escape_string($MySQL, $_POST['country']);

    $query_insert = "INSERT INTO users (user_firstname, user_lastname, email, username, password, country_id) 
                     VALUES ('$firstname', '$lastname', '$email', '$username', '$password', '$country_id')";
    
    if (mysqli_query($MySQL, $query_insert)) {
        echo "<p>Korisnik uspješno registriran!</p>";
    } else {
        echo "<p>Došlo je do pogreške pri registraciji: " . mysqli_error($MySQL) . "</p>";
    }
}

mysqli_close($MySQL);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registracija korisnika</title>
</head>
<body>

    <h2>Registracijski obrazac</h2>

    <form method="POST" action="">
        <div>
            <label for="firstname">Ime:</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div>
            <label for="lastname">Prezime:</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="username">Korisničko ime:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div>
            <label for="password">Lozinka:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="country">Zemlja:</label>
            <select id="country" name="country" required>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['country_name'] . " (" . $row['country_code'] . ")</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <button type="submit">Registriraj se</button>
        </div>
    </form>

</body>
</html>
