<h1>Session</h1>

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
echo '<pre><code class="lang:array hljs">';
print_r($_COOKIE);
echo '</code></pre>';

