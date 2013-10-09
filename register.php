<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

if ($_POST && isset($_POST['user']) && isset($_POST['pass']))
{
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);
    $name = trim($_POST['name']);

    $connection = db_connect($db_host, $db_user, $db_pass, $db);
    $user = mysqli_real_escape_string($connection, $user);
    $pass = mysqli_real_escape_string($connection, $pass);
    $name = mysqli_real_escape_string($connection, $name);

    if (mb_strlen($user) < 5)
    {
        die(error('Дължината на потребителското име трябва да е най-малко 5 (пет) символа.'));
    }
    if (mb_strlen($pass) < 5)
    {
        die(error('Дължината на паролата трябва да е най-малко 5 (пет) символа.'));
    }
    $q = mysqli_query($connection, 'SELECT username FROM users WHERE username="' . $user . '"') or die(error_query());
    if (mysqli_num_rows($q) > 0)
    {
        die(error('Потребител с такова потребителско име вече съществува!<br>Моля, изберете друго.'));
    }

    $q = mysqli_query($connection,
        'INSERT INTO users (username, password, name, is_admin) VALUES ("' . $user . '", "' . $pass . '", "' . $name . '", 0)')
        or die(error_query());
    $successMsg = 'Новият потребител бе регистриран успешно!';
}

$pageTitle = 'Registration';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';

?>
	<section class="grid_8">
        <header>
            Регистрирай нов потребител
        </header>
        <form action="" method="POST">
            <table class="login">
                <tr>
                    <td><label for="user">Потребителсто име</label></td>
                    <td><input type="text" id="user" required name="user" /></td>
                </tr>
                <tr>
                    <td><label for="pass">Парола</label></td>
                    <td><input type="password" id="pass" required name="pass" /></td>
                </tr>
                <tr>
                    <td><label for="name">Име</label></td>
                    <td><input type="text" id="name" name="name" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Изпрати" /></td>
                </tr>
            </table>
        </form>

        <?php if(isset($successMsg)): ?>
        <div class="success">
            <?= $successMsg; ?>
        </div>
        <?php endif; ?>
    </section>

	<?php
    include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';
    ?>

<?php
include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>