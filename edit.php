<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

if (!$_SESSION['isAdmin']) // only admin may edit, user does not have permission
{
    die(error('Вие нямате правомощия да редактирате съобщение!<br>Само администраторът има права да извърши операцията!'));
    exit;
}

if ($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['group']) && isset($_POST['message']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $group = trim($_POST['group']);
    $message = trim($_POST['message']);

    $connection = db_connect($db_host, $db_user, $db_pass, $db);
    $title = mysqli_real_escape_string($connection, $title);
    $content = mysqli_real_escape_string($connection, $content);
    $group = (int)mysqli_real_escape_string($connection, $group);
    $message = (int)mysqli_real_escape_string($connection, $message);

    if ($title == '' || $content == '' || $group <= 0 || $message <= 0)
    {
        die(error('Въведените данни са невалидни!'));
    }

    $q = mysqli_query($connection, 'SELECT group_id FROM groups WHERE group_id=' . $group) or die(error_query());
    if (mysqli_num_rows($q) != 1)
    {
        die(error('Невалидна категория!'));
    }

    $q = mysqli_query($connection, 'SELECT message_id FROM messages WHERE message_id=' . $message) or die(error_query());
    if (mysqli_num_rows($q) != 1)
    {
        die(error('Несъществуващо съобщение за редактиране!'));
    }

    $query = 'UPDATE messages
              SET title="' . $title  . '", content="' . $content . '", group_id=' . $group . '
              WHERE message_id=' . $message;
    mysqli_query($connection, $query) or die(error_query());

    $successMsg = 'Избраното съобщение бе редактирано успешно!';
}

$pageTitle = 'New message';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';

?>
    <section class="grid_8">
        <header>
            Редактиране на съобщение
        </header>
        <form action="" method="POST">

        <?php
        if (!$_GET || !isset($_GET['message']))
        {
            die(error('Не сте избрали съобщение за редактиране!'));
        }
        $messageID = (int)trim($_GET['message']);
        if ($messageID <= 0)
        {
            die(error('Избрали сте несъществуващо съобщение!'));
        }
        $connection = db_connect($db_host, $db_user, $db_pass, $db);
        $query = 'SELECT title, content, group_id FROM messages WHERE message_id=' . $messageID;
        $q = mysqli_query($connection, $query) or die(error_connection());
        if (mysqli_num_rows($q) != 1)
        {
            die(error('Избрали сте несъществуващо съобщение!'));
        }
        $row = mysqli_fetch_assoc($q);
        $selectedIndex = $row['group_id'];
        ?>

            <table class="login">
                <tr>
                    <td><label for="title">Ново заглавие</label></td>
                    <td><input type="text" id="title" maxlenght="50" required name="title" value="<?= $row['title']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="content">Ново съдържание</label></td>
                    <td><textarea id="content" rows="5" maxlength="250" required name="content"><?= $row['content']; ?></textarea></td>
                </tr>
                <tr>
                    <td><label for="group">Нова група</label></td>
                    <td>
                        <select id="group" required name="group">
                            <?php
                            $query = 'SELECT group_id, title FROM groups';
                            $q = mysqli_query($connection, $query) or die(error_connection());
                            while ($row = mysqli_fetch_assoc($q))
                            {
                                echo '<option value="' . $row['group_id'] . '" ';
                                if ($row['group_id'] == $selectedIndex)
                                {
                                    echo 'selected';
                                }
                                echo ' >' . $row['title'] . '</option>' . PHP_EOL;
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Промени" /></td>
                </tr>
            </table>
            <input type="hidden" name="message" value="<?= $messageID; ?>" />
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