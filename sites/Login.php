<div class="row">
    <div class="col s12 m6 l4">
        <h4>LOGIN - Formular</h4>
        <form action="/Account/check" method="post">
            <input type="text" name="name" value="admin">
            <input type="password" name="password" value="1234">
            <input type="submit" class="btn" value="Login">
        </form>
    </div>
    <script>
        // form submit
        $(document).ready(function () {
            $('form').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();
                data = data.replace(/password=([^&]*)/, function (match, p1) {
                    return 'password=' + sha512(p1);
                });
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function (data) {
                        console.log(data);
                        if (data == 1) {
                            window.location.href = "/Account/Account";
                        } else {
                            M.toast({html: 'Login not correct', classes: 'rounded red'});
                        }
                    }
                });
            });
        });
    </script>

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