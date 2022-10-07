<!doctype html>
<html lang="pt-BR">
    <head><title>Justificativa - Requisição</title></head>
    <body onload="onloadPage()">

        <form id="frm_collect_justify" method="post" action="/institucional/requisicoes/doAction">
            <?php 
            
                if(isset($info)){
                    if($info=='wrong_justify'){
                        echo '<p>Uma justificativa válida deve ser informada para realizar a alteração da requisição.</p>';
                    }
                    else if($info=='wrong_date'){
                        echo '<p>Forneça uma data válida.</p>';
                    }
                    else if($info=='wrong_none_date_set'){
                        echo '<p>A data de agendamento permaneceu a mesma, portanto a requisição não foi alterada.</p>';
                    }
                }
            
            ?>
            <input type="hidden" name="_token" value="{{{csrf_token()}}}">
            <input type="hidden" name="op_type" value="<?= $op_type ?>">
            <input type="hidden" name="_id" value="<?= $id ?>">
            Justificativa:
            <textarea id="txtJustify" name="txtJustify" rows="4" cols="50"></textarea>

            <p>Data de agendamento: <?php echo date('d/m/Y H:i:s', $datetime); ?></p>
            <?php 
            
            
                if($op_type=='change'){
                    echo '<input type="datetime-local" id="txtDatetime" name="txtDatetime" onChange="onRestoreDateInfo()">';
                    echo '<input type="hidden" id="txtDate_info_obj" name="txtDate_info_obj" value="resetted">';
                    echo '<input type="hidden" id="txtTimestamp" name="txtTimestamp" value="'.$datetime.'">';

                    echo 'Alterar Data<input type="radio" name="txtRadio" id="txtRadio" onclick="ChangeDate()">
                          Cancelar alteração<input type="radio" name="txtRadioResetDate" id="txtRadioResetDate" onclick="CancelDate()">';

                    echo '<script type="text/javascript">
                    
                            function ChangeDate(){
                                obj_date = document.getElementById("txtDatetime")
                                obj_date.value=null
                                obj_date.disabled = false

                                obj_change_date = document.getElementById("txtRadio")
                                obj_change_date.disabled = true
                                obj_change_date.checked = true
                                

                                obj_reset_date = document.getElementById("txtRadioResetDate")
                                obj_reset_date.checked = false
                                obj_reset_date.disabled = false
                                

                                obj_info_date = document.getElementById("txtDate_info_obj")
                                obj_info_date.value="changed"


                            }

                            function CancelDate(){
                                obj_date = document.getElementById("txtDatetime")
                                obj_date.value=null
                                obj_date.disabled = true

                                obj_change_date = document.getElementById("txtRadio")
                                obj_change_date.checked = false
                                obj_change_date.disabled = false
                                
                                

                                obj_reset_date = document.getElementById("txtRadioResetDate")
                                obj_reset_date.checked = true
                                obj_reset_date.disabled = true

                                obj_info_date = document.getElementById("txtDate_info_obj")
                                obj_info_date.value="resetted"
                            }


                            function onloadPage(){
                                // get the iso time string formatted for usage in an input[\'type="datetime-local"\']
                                var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                                var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0,-1);
                                var localISOTimeWithoutSeconds = localISOTime.slice(0,16);

                                // select the "datetime-local" input to set the default value on
                                var dtlInput = document.querySelector(\'input[type="datetime-local"]\');

                                // set it and forget it ;)
                                dtlInput.value = localISOTime.slice(0,16);
                                
                                obj_date = document.getElementById("txtDatetime")
                                obj_date.value=null
                                obj_date.disabled = true

                            }
                            



                    </script>';
                    //echo '<a id="resetDate" onclick="resetDate()">Restaurar data</a>';
                    echo '<p>*** Ao alterar uma requisição, esta automaticamente estará sendo aprovada.</p>';
                }else if($op_type=="repprove"){
                    echo '<input type="checkbox" name="txtShouldDelete" id="txtShouldDelete" value="yes"> Deletar requisição';
                }
            
            ?>
            <input type="submit" value="Realizar operação">

        </form>


    </body>
</html>
