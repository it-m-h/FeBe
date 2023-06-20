<?php
if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] != 5)
    header('Location: /');
?>
<h1>User</h1>

<p>
    Beispiel für eine Userseite
</p>