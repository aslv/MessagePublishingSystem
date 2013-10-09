    <aside class="grid_2">
    	<?php
    	if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] === true) 
    	{
    		echo '
    		<div class="avatar">
    			Здравей, <span class="sc">';
            if ($_SESSION['name'] != '')
            {
                echo $_SESSION['name'];
            }
            else
            {
                echo $_SESSION['username'];
            } 
            echo '!</span><br>Статут: ';
            if ($_SESSION['isAdmin'])
            {
                echo 'Администратор';
            }
            else
            {
                echo 'Потребител';
            }
    		echo '<div class="centre"><a href="logout.php" class="button">Изход</a></div></div>';
    	}
    	?>
    </aside>