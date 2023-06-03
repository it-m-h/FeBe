<?php
if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] != 9)
    header('Location: /');
?>
<h1>Guest</h1>

<p>
    Beispiel für eine Guestseite
</p>