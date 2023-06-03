<?php
use App\User\User;
use Handlebars\Handlebars;
use lib\Database;

$user = new User(null);
$user = $user->getUsers();
$handlebars = new Handlebars();

$db = new Database();
$groups = $db->getArray('SELECT * FROM groups');
/* echo '<pre>';
print_r($groups);
echo '</pre>'; */
/* 
echo '<form id="UserForm" action="/App/User/Save" method="post" class="row">';
$user = new App\User\User(null);
$html = $user->getFormFields();
echo $html;
echo '</form>'; 
*/
?>
<h1>Sites: SQLITE3 - User with AJAX to the App/User</h1>
<div class="row">
    <div class="col s3 grey lighten-2 z-depth-2">
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
                    $i=0;
                    foreach ($groups as $group) {
                        if($i==0){
                            echo '<option value="'.$group['group_id'].'" selected>'.$group['group_name'].'</option>';
                            $i++;
                        }
                        else{
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
    <div class="col s9">
        <section id="UserListe">
            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead class="black white-text">
                            <tr>
                                <th>edit</th>
                                <th>Pfad</th>
                                <th>Name</th>
                                <th>Passwort</th>
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
                                <td>{{user_passwort}}</td>
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
<script>
    /*  .edit click */
    $('.edit').click(function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
            type: "GET",
            url: "/App/User/getUser/" + id,
            dataType: 'json',
            success: function(response){
                if(response['error']){
                    M.toast({html: response['error'] , classes: 'red'});
                }else{
                    $('#user_id').val(response['user_id']);
                    $('#user_id').addClass('valid');
                    $('#user_pfad').val(response['user_pfad']);
                    $('#user_pfad').addClass('valid');
                    $('#user_name').val(response['user_name']);
                    $('#user_name').addClass('valid');
                    $('#user_passwort').val(response['user_passwort']);
                    $('#user_passwort').addClass('valid');
                    $('#user_gruppe').val(response['user_gruppe']);
                    $('#user_gruppe').addClass('valid');
                    $('#user_RFID').val(response['user_RFID']);
                    $('#user_RFID').addClass('valid');
                    M.toast({html: 'Daten geladen' , classes: 'grey darken-2'});
                    M.updateTextFields();
                    $('select').formSelect();


                }
            }
        });
    });

    // status click toggleUserStatus
    $('.status').click(function(){

        abfrage = confirm("Benutzer aktivieren/deaktivieren?");
        if (abfrage == false) {
            return false;
        }else{
            var id = $(this).parent().attr('data-id');
            $.ajax({
                type: "GET",
                url: "/App/User/toggleUserStatus/" + id,
                dataType: 'json',
                success: function(response){
                    if(response['error']){
                        M.toast({html: response['error'] , classes: 'red'});
                    }else{
                        M.toast({html: response['success'] , classes: 'green'});
                        setTimeout(function(){
                            location.reload();
                        }, 700);
                    }
                }
            });
        }
    });

    /* #clear click event -> form leeren */
    $('#clear').click(function(){
        $('#UserForm').find('input').each(function(){
            var value = $(this).attr('value');
            $(this).val(value);
            $(this).removeClass('valid');
        });
        M.updateTextFields();
        $('select').formSelect();
        M.toast({html: 'Formular geleert' , classes: 'grey darken-2'});
    });

    $('form').submit(function(e){
        e.preventDefault();
        var form = $('#UserForm');
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            success: function(response){
                if(response['success']){
                    $('#UserForm').find('input').each(function(){
                        var value = $(this).attr('value');
                        $(this).val(value);
                    });  
                    M.toast({html: 'Gespeichert' , classes: 'green darken-2'}); 
                    setTimeout(function(){
                        location.reload();
                    }, 700);

                } else if(response['error']){
                    for (let key in response.data) {
                        let value = response.data[key];
                        M.toast({html: key + ': ' + value , classes: 'red'});
                    }
                }
                
            }
        });
    });
</script>