<?php
use App\Group\Group;
use Handlebars\Handlebars;

$Group = new Group(null);
$Group = $Group->getGroups();
$handlebars = new Handlebars();

?>
<h1>Sites: SQLITE3 - GROUP with AJAX to the App/Group</h1>
<div class="row">
    <div class="col s3 grey lighten-2 z-depth-2">
        <form id="GroupForm" action="/App/Group/Save" method="post" class="row">
            <div class="input-field col s6">
                <input id="save" name="save" type="submit" class="btn red white-text btn w100" value="Speichern">
            </div>
            <div class="input-field col s6">
                <input id="clear" name="clear" type="submit" class="btn green white-text btn w100" value="Clear">
            </div>
            <div class="input-field col s12">
                <input id="group_id" name="group_id" type="number" class="input" required="" value="0">
                <label for="group_id" class="active">ID:</label>
            </div>
            <div class="input-field col s12">
                <input id="group_name" name="group_name" type="text" class="input" required="" minlength="4" maxlength="255">
                <label for="group_name" class="">Name:</label>
            </div>
            <div class="input-field col s12">
                <input id="group_rights" name="group_rights" type="number" class="input" required="" min="1" max="9" step="1">
                <label for="group_rights">Rights:</label>
            </div>
        </form>
    </div>
    <div class="col s9">
        <section id="GroupListe">
            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead class="black white-text">
                            <tr>
                                <th>edit</th>
                                <th>Name</th>
                                <th>Rights</th>
                                <th>active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $template = '
                            {{#each this}}
                            {{#if group_active}}
                                <tr>
                            {{else}}
                                <tr class="grey lighten-2">
                            {{/if}}
                                <td data-id="{{group_id}}"><button class="edit green btn"><i class="material-icons">create</i></button></td>
                                <td>{{group_name}}</td>
                                <td>{{group_rights}}</td>
                                <td data-id="{{group_id}}">
                                    {{#if group_active}}
                                        <button class="status red btn"><i class="material-icons">delete</i></button>
                                    {{else}}
                                        <button class="status black btn"><i class="material-icons">autorenew</i></button>
                                    {{/if}}
                                </td>
                            </tr>
                            {{/each}}
                            ';
                            echo $handlebars->render($template, $Group);
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
            url: "/App/Group/getGroup/" + id,
            dataType: 'json',
            success: function(response){
                if(response['error']){
                    M.toast({html: response['error'] , classes: 'red'});
                }else{
                    $('#group_id').val(response['group_id']);
                    $('#group_id').addClass('valid');
                    $('#group_name').val(response['group_name']);
                    $('#group_name').addClass('valid');
                    $('#group_rights').val(response['group_rights']);
                    $('#group_rights').addClass('valid');
                    M.toast({html: 'Daten geladen' , classes: 'grey darken-2'});
                    M.updateTextFields();
                    $('select').formSelect();


                }
            }
        });
    });

    $('.status').click(function(){

        abfrage = confirm("Benutzer aktivieren/deaktivieren?");
        if (abfrage == false) {
            return false;
        }else{
            var id = $(this).parent().attr('data-id');
            $.ajax({
                type: "GET",
                url: "/App/Group/toggleGroupStatus/" + id,
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

    $('#clear').click(function(){
        $('#GroupForm').find('input').each(function(){
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
        var form = $('#GroupForm');
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            success: function(response){
                if(response['success']){
                    $('#GroupForm').find('input').each(function(){
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