<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

$pageTitle = 'Messages';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

$connection = db_connect($db_host, $db_user, $db_pass, $db); // no alias for clarity
$query = 'SELECT messages.datetime, users.username, users.name, messages.title as msg, messages.content, groups.title as gr FROM users, messages, groups
WHERE users.username="' . $_SESSION['username'] . '" AND messages.user_id=users.user_id AND messages.group_id=groups.group_id
ORDER BY messages.datetime';
$q = mysqli_query($connection, $query) or die(mysqli_error($connection));

?>
    
    <?php include 'includes' . DIRECTORY_SEPARATOR . 'nav.php'; ?>
    
    <section class="grid_8">
        <header>
            Списък със съобщения
        </header>
        
        <?php
        while ($row = mysqli_fetch_assoc($q))
        {
            
        	echo /*date($dateFormat, $row['datetime'])*/$row['datetime'] . ' | ' . $row['username'] . ' | ' .
        		 $row['name'] . ' | ' . $row['msg'] . ' | ' . $row['gr'] . '<br>' .
        		 $row['content'] . '<br><br><br>';
                 
            //echo '<pre>' . print_r($row) . '</pre><br>';
        }
        ?>

    </section>

	<?php
    include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';
    ?>

<?php
include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>