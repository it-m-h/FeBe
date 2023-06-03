<h1>Rights</h1>
<form action="/UseFeBe/Rights" method="post">
    <input type="submit" name="logout" value="LogOut">
</form>

<?php 

if(isset($_POST['name'])){
    $_SESSION['name'] = $_POST['name'];
    if($_POST['name'] == 'admin'){
        $_SESSION['Rights'] = 1;
    }elseif($_POST['name'] == 'guest'){
        $_SESSION['Rights'] = 9;
    }elseif($_POST['name'] == 'user'){
        $_SESSION['Rights'] = 5;
    }
}
if(isset($_POST['logout'])){
    unset($_SESSION['name']);
    unset($_SESSION['Rights']);
}
?>
<div class="row grey lighten-3">
    <div class="col s4">
        <h4>Admin Login</h4>
        <form action="/UseFeBe/Rights" method="post">
            <input type="text" name="name" value="admin">
            <input type="submit" value="Login">
        </form>
    </div><div class="col s4">
        <h4>User Login</h4>
        <form action="/UseFeBe/Rights" method="post">
            <input type="text" name="name" value="user">
            <input type="submit" value="Login">
        </form>
    </div><div class="col s4">
        <h4>Guest Login</h4>
        <form action="/UseFeBe/Rights" method="post">
            <input type="text" name="name" value="guest">
            <input type="submit" value="Login">
        </form>
    </div>
</div>

<?php
new lib\Template('Sites/Rights', null, 'echo');
