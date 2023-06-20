<div class="row">
    <div class="col s12 m6 l4">
        <h4>LOGIN - Formular</h4>
        <form action="/Account/check" method="post">
            <input type="text" name="name" value="admin">
            <input type="password" name="password" value="1234">
            <input type="submit" class="btn" value="Login">
        </form>
    </div>

    <div class="col s12 m6 l4 offset-l4">
        <h4>Standard - Login</h4>
        <table>
            <thead>
            <tr>
                <th>Benutzername</th>
                <th>admin</th>
                <th>rights</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>admin</td>
                    <td>1234</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>user</td>
                    <td>1234</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>guest</td>
                    <td>1234</td>
                    <td>9</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>