<?php
if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] <1 ) header('Location: /');
?>

<h1>Hallo: <?php echo $_SESSION['user_name'] ?></h1>

<p>
    Beispiel für eine Account - Seite.
</p>

<?php
echo '<pre><code class="lang:array hljs">';
print_r($_SESSION);
echo '</code></pre>';