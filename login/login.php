<?php 
require __DIR__.'/bootstrap.php';

// LOGOUT scenarijus
if (isset($_GET['logout'])) {
    //keli budai
    // $_SESSION['login'] = 0;
    // unset($_SESSION['user']);

    // kitas
    session_destroy();
    header('Location: '.URL.'login.php');
    die;
}


// Jau prisijungusio vartotojo scenarijus
if(isset($_SESSION['login']) && 1 == $_SESSION['login']) {
    header('Location: '.URL.'private.php');
    die;
}


// POST metodo scenarijus LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $users = file_get_contents(__DIR__.'/users.json');
    $users = json_decode($users, 1);

    $postName = $_POST['name'] ?? '';
    $postPass = $_POST['pass'] ?? '';

    foreach ($users as $user) {
        if ($postName == $user['name']) { // <--- turim useri
            if (password_verify($postPass, $user['pass'])) { // <--- viskas OK
                 // sugalvojam kad 1 reiks prisijungusi vartotoja
                //  o 0 reiks neprisijungusi
                $_SESSION['login'] = 1;
                $_SESSION['user'] = $user;
                header('Location: '.URL.'private.php');
                die;
            }
        }
    }
    $_SESSION['error_msg'] = 'Password or Name is invalid.';
    header('Location: '.URL.'login.php');
    die;
}



// Prisijungimo formos rodymo scenarijus

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login page</h1>
    <!-- tikrinam ar yra pranesimas -->
    <?php if(isset($_SESSION['error_msg'])): ?> 
        <!-- pranesimas yra. atvaizduojame -->
        <h3 style="color:red"><?= $_SESSION['error_msg'] ?></h3>
        <!-- atvaizdavome. nebereikalingas istrinam, kad nerodytu sekati karta -->
        <?php unset($_SESSION['error_msg']) ?>
    <?php endif ?>
    <form action="<?= URL ?>login.php" method="post">
        NAME:<input type="text" name="name">
        PASSWORD:<input type="password" name="pass">
        <button type="submit">login</button>
    </form>
</body>
</html>