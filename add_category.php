<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

if ($_POST && isset($_POST['title']) && isset($_POST['content']))
{
	$title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $connection = db_connect($db_host, $db_user, $db_pass, $db);
    $title = mysqli_real_escape_string($connection, $title);
    $content = mysqli_real_escape_string($connection, $content);

    if ($title == '' || $content == '')
    {
        die(error('Въведените данни са невалидни!'));
    }

    $q = mysqli_query($connection,
        'INSERT INTO groups (title, description) VALUES ("' . $title . '", "' . $content . '")') or die(error_query());
    $successMsg = 'Групата бе добавена успешно!';
}

$pageTitle = 'Add category';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';

?>
	<section class="grid_8">
        <header>
            Добави група
        </header>
        <form action="" method="POST">
        	<table class="login">
        		<tr>
        			<td><label for="title">Наименование на<br>групата (категорията)</label></td>
        			<td><input type="text" id="title" maxlenght="50" required name="title" /></td>
        		</tr>
        		<tr>
        			<td><label for="content">Описание</label></td>
        			<td><textarea id="content" maxlength="250" required name="content"></textarea></td>
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