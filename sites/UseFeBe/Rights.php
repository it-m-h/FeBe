<h1>Rights / Login</h1>
<form action="/UseFeBe/Rights" method="post">
    <input type="submit" name="logout" value="LogOut">
</form>

<?php 
use lib\Auth;

if(isset($_POST['name']) && isset($_POST['password'])){
    $loginname = $_POST['name'];
    $password = sha1($_POST['password']);
    Auth::chkLogin($loginname, $password);
}
?>
<div class="row grey lighten-3">
    <div class="col s4">
        <h4>Admin Login</h4>
        <form action="/UseFeBe/Rights" method="post">
            <input type="text" name="name" value="admin">
            <input type="password" name="password" value="1234">
            <input type="submit" value="Login">
        </form>
    </div><div class="col s4">
        <h4>User Login</h4>
        <form action="/UseFeBe/Rights" method="post">
            <input type="text" name="name" value="user">
            <input type="password" name="password" value="1234">
            <input type="submit" value="Login">
        </form>
    </div><div class="col s4">
        <h4>Guest Login</h4>
        <form action="/UseFeBe/Rights" method="post">
            <input type="text" name="name" value="guest">
            <input type="password" name="password" value="1234">
            <input type="submit" value="Login">
        </form>
    </div>
</div>

<?php
new lib\Template('Sites/Rights', null, 'echo');
