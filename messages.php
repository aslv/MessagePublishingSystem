<?php
require 'includes' . DIRECTORY_SEPARATOR . 'session.php';
require 'includes' . DIRECTORY_SEPARATOR . 'constants.php';

$pageTitle = 'Messages';
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

$connection = db_connect($db_host, $db_user, $db_pass, $db);

$queryGroupCheck = '';
$querySortBy = '';

if($_GET)
{
    if (isset($_GET['group'])) // a bit complicated because the group filter is multiple
    {
        foreach ($_GET['group'] as $group)
        {
            $groups[] = (int)mysqli_real_escape_string($connection, trim($group));
        }
        $q = mysqli_query($connection, 'SELECT group_id FROM groups') or die(error_query());
        while ($row = mysqli_fetch_assoc($q))
        {
            $found = false;
            // in $validGroups[] we get group_ids of selected groups by user
            foreach ($groups as $group)
            {
                if ($row['group_id'] == $group)
                {
                    $found = true;
                    break;
                }
            }
            if ($found)
            {
                $validGroups[] = $row['group_id'];
            }
        }
        // building query
        $queryGroupCheck = ' AND (';
        $lengthMinus1 = count($validGroups) - 1;
        for ($i=0; $i < $lengthMinus1; $i++)
        { 
            $queryGroupCheck .= 'groups.group_id=' . $validGroups[$i] . ' OR ';
        }
        $queryGroupCheck .= 'groups.group_id=' . $validGroups[$lengthMinus1] . ')';
    }
    $querySortBy = ' ';
    if (isset($_GET['date']))
    {
        $date = mysqli_real_escape_string($connection, trim($_GET['date']));
        // the default value is DESC because the homework says so :)
        if ($date == 'ASC' || $date == 'DESC')
        {
            $querySortBy .= 'ORDER BY messages.datetime ' . $date;
        }
        else
        {
            $querySortBy .= 'ORDER BY messages.datetime DESC';
        }
    }
    else
    {
        $querySortBy .= 'ORDER BY messages.datetime DESC';
    }
}
else
{
    $querySortBy = ' ORDER BY messages.datetime DESC';
}

// although it seems sophisticated, the query is rather simply - we just get the required information for each record
$query =
'SELECT messages.message_id, messages.datetime, users.username, users.name, messages.title as msg, messages.content, groups.title as gr
 FROM users, messages, groups
 WHERE messages.user_id=users.user_id AND messages.group_id=groups.group_id';
$query .= $queryGroupCheck . $querySortBy; // adding conditions for selected filters

$q = mysqli_query($connection, $query) or die(error_query());
?>
    
    <?php include 'includes' . DIRECTORY_SEPARATOR . 'nav.php'; ?>
    
    <section class="grid_6">
        <header>
            Списък със съобщения
        </header>
        
        <table class="msg">
            <tr>
                <th>#</th><th>Публикувано</th><th>Потребителско име</th><th>Име</th><th>Заглавие</th><th>Група<th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($q))
            {
                echo '<tr><td>' . $row['message_id'] . '</td><td>' . $row['datetime'] . '</td><td>'
                 . wordwrap($row['username'], 20, '<br>', true) . '</td><td>' 
                 . wordwrap($row['name'], 20, '<br>', true) . '</td><td>' . wordwrap($row['msg'], 20, '<br>', true) . '</td><td>'
                 . wordwrap($row['gr'], 20, '<br>', true). '</td></tr>';
                echo '<tr><td colspan="4">' . wordwrap($row['content'], 50, '<br>', true) . '</td>';
                if ($_SESSION['isAdmin']) // only admin may edit or delete, user does not have permission
                {
                    echo
                    '<td><a href="edit.php?message=' . $row['message_id'] . '"><img src="img/edit.png" /></a></td>
                <td><a href="delete.php?message=' . $row['message_id'] . '"><img src="img/delete.png" /></a></td>';
                }
                else
                {
                    echo '<td></td><td></td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
    </section>
    <section class="grid_2" style="overflow: visible;">
        <div class="filter">
            <form method="GET" action="messages.php">
                <table>
                    <tr>
                        <td><label for="date">Сортиране по дата</label></td>
                        <td>
                            <select id="date" name="date">
                                <option value="ASC">Възходящо</option>
                                <option selected value="DESC">Низходящо</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="group">Филтър по група/и</label></td>
                        <td>
                            <select id="group" name="group[]" multiple>
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
                        <td colspan="2">
                            <div><input type="submit" value="Покажи" /></div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </section>

	<?php
    include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';
    ?>

<?php
include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>