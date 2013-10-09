<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

if (!$_SESSION['isAdmin']) // only admin may delete, user does not have permission
{
    die(error('Вие нямате правомощия да изтривате съобщение!<br>Само администраторът има права да извърши операцията!'));
    exit;
}

if ($_POST && isset($_POST['message']))
{
    $message = trim($_POST['message']);

    $connection = db_connect($db_host, $db_user, $db_pass, $db);
    $message = (int)mysqli_real_escape_string($connection, $message);

    if ($message <= 0)
    {
        die(error('Несъществуващо съобщение за изтриване!'));
    }

    $q = mysqli_query($connection, 'SELECT message_id FROM messages WHERE message_id=' . $message) or die(error_query());
    if (mysqli_num_rows($q) != 1)
    {
        die(error('Несъществуващо съобщение за редактиране!'));
    }

    $query = 'DELETE FROM messages WHERE message_id=' . $message;
    mysqli_query($connection, $query) or die(error_query());

    $successMsg = 'Избраното съобщение бе изтрито успешно!';
}

$pageTitle = 'New message';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';

?>
    <section class="grid_8">
        <header>
            Редактиране на съобщение
        </header>

        <!-- rather offhand, but it works :) -->
        <?php if(isset($successMsg)): ?>
        <div class="success">
            <?= $successMsg; ?>
        </div>
        <?php exit; ?>
        <?php endif; ?>

        <form action="delete.php" method="POST">
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
        $query = 'SELECT message_id FROM messages WHERE message_id=' . $messageID;
        $q = mysqli_query($connection, $query) or die(error_connection());
        if (mysqli_num_rows($q) != 1)
        {
            die(error('Избрали сте несъществуващо съобщение!'));
        }
        ?>
            <div>
                Сигурни ли сте, че искате да изтриете това съобщение?
            </div>
            <input type="submit" value="Да, изтрий!" />
            <input type="hidden" name="message" value="<?= $messageID; ?>" />
        </form>

    </section>

    <?php
    include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';
    ?>

<?php
include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>