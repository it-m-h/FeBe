<?php
if (!isset($_SESSION['Rights']) || $_SESSION['Rights'] != 1)
    header('Location: /');

use App\User\User;
use Handlebars\Handlebars;
use lib\Database;

$user = new User(null);
$user = $user->getUsers();
$handlebars = new Handlebars();

$db = new Database();
$groups = $db->getArray('SELECT * FROM groups');
?>
<h1>Sites: SQLITE3 - User with AJAX to the App/User</h1>
<div class="row">
    <div class="col s6 grey lighten-2 z-depth-2">
        <form id="UserForm" action="/App/User/Save" method="post" class="row">
            <div class="input-field col s6">
                <input id="save" name="save" type="submit" class="btn red white-text btn w100" value="Speichern">
            </div>
            <div class="input-field col s6">
                <input id="clear" name="clear" type="submit" class="btn green white-text btn w100" value="Clear">
            </div>
            <div class="input-field col s12">
                <input id="user_id" name="user_id" type="number" class="input" required="" value="0">
                <label for="user_id" class="active">ID:</label>
            </div>
            <div class="input-field col s12">
                <input id="user_pfad" name="user_pfad" type="text" class="input" required="" minlength="4" maxlength="255">
                <label for="user_pfad" class="">Pfad:</label>
            </div>
            <div class="input-field col s12">
                <input id="user_name" name="user_name" type="text" class="input" required="" minlength="4" maxlength="255">
                <label for="user_name">Name:</label>
            </div>
            <div class="input-field col s12">
                <input id="user_passwort" name="user_passwort" type="text" class="input" required="" minlength="4" maxlength="255">
                <label for="user_passwort">Passwort:</label>
            </div>


            <div class="input-field col s12">
                <select id="user_gruppe" name="user_gruppe" value="1">
                    <?php
                    $i = 0;
                    foreach ($groups as $group) {
                        if ($i == 0) {
                            echo '<option value="'.$group['group_id'].'" selected>'.$group['group_name'].'</option>';
                            $i++;
                        } else {
                            echo '<option value="'.$group['group_id'].'">'.$group['group_name'].'</option>';
                        }
                    }
                    ?>
                </select>
                <label>Gruppe:</label>
            </div>

            <div class="input-field col s12">
                <input id="user_RFID" name="user_RFID" type="text" class="input">
                <label for="user_RFID">RFID:</label>
            </div>
        </form>
    </div>
    <div class="col s6">
        <section id="UserListe">
            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead class="black white-text">
                            <tr>
                                <th>edit</th>
                                <th>Pfad</th>
                                <th>Name</th>
                                <!-- <th>Passwort</th> -->
                                <th>Gruppe</th>
                                <th>RFID</th>
                                <th>active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $template = '
                            {{#each this}}
                            {{#if user_active}}
                                <tr>
                            {{else}}
                                <tr class="grey lighten-2">
                            {{/if}}
                                <td data-id="{{user_id}}"><button class="edit green btn"><i class="material-icons">create</i></button></td>
                                <td>{{user_pfad}}</td>
                                <td>{{user_name}}</td>
                                <!-- <td>{{user_passwort}}</td> -->
                                <td>{{group_name}} ({{group_rights}})</td>
                                <td>{{user_RFID}}</td>
                                <td data-id="{{user_id}}">
                                    {{#if user_active}}
                                        <button class="status red btn"><i class="material-icons">delete</i></button>
                                    {{else}}
                                        <button class="status black btn"><i class="material-icons">autorenew</i></button>
                                    {{/if}}
                                </td>
                            </tr>
                            {{/each}}
                            ';
                            echo $handlebars->render($template, $user);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<style>
    td, th {
        border-radius: 0px;
    }
</style>

<script type="module">
    import {onEditButtonClick, onStatusButtonClick, onClearButtonClick, onFormSubmit} from '/js/adminUser.js';
    onEditButtonClick();
    onStatusButtonClick();
    onClearButtonClick();
    onFormSubmit();
</script>
