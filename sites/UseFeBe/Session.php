<h1>Session</h1>

Mit PHP kann z.B. ein Aufruf der Seite verhindert werden, wenn der User nicht eingeloggt ist.
<pre>
    if (!isset($_SESSION['Rights']))
        header('Location: /');
</pre>

<?php

// alle eigenen DEFINED ausgeben
$constants = get_defined_constants(true);
echo '<h3>DEFINED</h3>';
echo '<pre><code class="lang:array hljs">';
print_r($constants['user']);
echo '</code></pre>';

echo '<h3>PHP - Session</h3>';
echo '<pre><code class="lang:array hljs">';
// php sessionID ausgeben
echo 'Session ID: '.session_id().'<br><br>';
print_r($_SESSION);
echo '</code></pre>';

// alle jS cookies ausgeben
echo '<h3>JS Cookies</h3>';
echo '<p>Die PHPSESSID ändert sich nach jedem Login oder Logout. Weitere Sicherheiten sind noch nicht umgesetzt.</p>';
echo '<pre><code class="lang:array hljs">';
print_r($_COOKIE);
echo '</code></pre>';

