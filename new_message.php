<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

if ($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['group']))
{
	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	$group = trim($_POST['group']);

	$connection = db_connect($db_host, $db_user, $db_pass, $db);
	$title = mysqli_real_escape_string($connection, $title);
	$content = mysqli_real_escape_string($connection, $content);
	$group = (int)mysqli_real_escape_string($connection, $group);

	if (mb_strlen($title) > 50)
	{
		die(error('Заглавието на съобщението е прекалено дълго!'));
	}
	if (mb_strlen($content) > 250)
	{
		die(error('Съдържанието на съобщението е прекалено дълго!'));
	}
	if ($title == '' || $content == '' || $group <= 0)
	{
		die(error('Въведените данни са невалидни!'));
	}

	$q = mysqli_query($connection, 'SELECT group_id FROM groups WHERE group_id=' . $group) or die(error_query());
    if (mysqli_num_rows($q) != 1)
    {
    	die(error('Невалидна категория!'));
    }

    $query = 'INSERT INTO messages (user_id, title, content, group_id)
              VALUES (' . $_SESSION['userID'] . ', "' . $title . '", "'. $content .'", ' . $group . ')';
    mysqli_query($connection, $query) or die(error_query());
    $successMsg = 'Новото съобщение бе записано успешно!';
}

$pageTitle = 'New message';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';

?>
	<section class="grid_8">
        <header>
            Ново съобщение
        </header>
        <form action="" method="POST">
        	<table class="login">
        		<tr>
        			<td><label for="title">Заглавие</label></td>
        			<td><input type="text" id="title" maxlenght="50" required name="title" /></td>
        		</tr>
        		<tr>
        			<td><label for="content">Съдържание</label></td>
        			<td><textarea id="content" rows="5" maxlength="250" required name="content"></textarea></td>
        		</tr>
        		<tr>
        			<td><label for="group">Група</label></td>
        			<td>
        				<select id="group" required name="group">
        					<?php
        					$connection = db_connect($db_host, $db_user, $db_pass, $db);
        					$query = 'SELECT group_id, title FROM groups';
        					$q = mysqli_query($connection, $query) or die(error_connection());
        					while ($row = mysqli_fetch_assoc($q))
        					{
        						echo '<option value="' . $row['group_id'] . '">' . $row['title'] . '</option>';
        					}
        					?>
        				</select>
        			</td>
        		</tr>
        		<tr>
        			<td colspan="2"><input type="submit" value="Създай" /></td>
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