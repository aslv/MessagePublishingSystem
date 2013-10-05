<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

function valid_user($username, $password)
{
	if ($username == '' || $password == '')
	{
		die(error('Въведените потребителско име и/или парола са грешни!')); // empty username || password
	}
	$connection = db_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db']);
	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);
	$q = mysqli_query($connection, 'SELECT * FROM users WHERE username="' . $username . '"') or die(error_query());
	if (mysqli_num_rows($q) == 1)
	{
		$row = mysqli_fetch_assoc($q);
		if ($row['password'] == $password)
		{
			return $row;
		}
		else
		{
			die(error('Въведените потребителско име и/или парола са грешни!')); // invalid password
		}
	}
	elseif (mysqli_num_rows($q) == 0)
	{
		die(error('Въведените потребителско име и/или парола са грешни!')); // invalid username
	}
	else
	{
		die(error('Възникна грешка!<br>Моля, опитайте по късно!')); // broken database
	}
}

if ($_POST && isset($_POST['user']) && isset($_POST['pass']))
{
	$username = trim($_POST['user']);
	$password = trim($_POST['pass']);
	if ($row = valid_user($username, $password))
	{
		$_SESSION['isLogged'] = true;
		$_SESSION['username'] = $row['username'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['isAdmin'] = $row['is_admin'];
		header('Location: messages.php');
		exit;
	}
}

$pageTitle = 'Login';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';
?>

    <?php include 'includes' . DIRECTORY_SEPARATOR . 'nav.php'; ?>
    
    <section class="grid_8">
        <header>
            Вход
        </header>
        <form action="" method="POST">
        	<table class="login">
        		<tr>
        			<td><label for="user">Потребителсто име</label></td>
        			<td><input type="text" id="user" required autofocus autocomplete="on" name="user" /></td>
        		</tr>
        		<tr>
        			<td><label for="pass">Парола</label></td>
        			<td><input type="password" id="pass" required name="pass" /></td>
        		</tr>
        		<tr>
        			<td><label for="name">Име</label></td>
        			<td><input type="password" id="name" name="name" /></td>
        		</tr>
        		<tr>
        			<td colspan="2"><input type="submit" value="Влез" /></td>
        		</tr>
        	</table>
        </form>
    </section>

    <?php
    include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';
    ?>

<?php
include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>