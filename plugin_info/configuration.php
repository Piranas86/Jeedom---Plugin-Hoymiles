<?php
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
  include_file('desktop', '404', 'php');
  die();
}
?>
<form class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Adresse IP du DTU}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Renseignez l'adresse IP de votre passerelle DTU hoymiles}}"></i></sup>
      </label>
      <div class="col-md-4">
        <input class="configKey form-control" data-l1key="ip_dtu" autocomplete="off" placeholder="{{192.168.1.xx}}"/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Port utilisé}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Renseigner le port utilisé par votre passerelle DTU hoymiles}}"></i></sup>
      </label>
      <div class="col-md-4">
        <input class="configKey form-control" data-l1key="port_dtu" placeholder="{{502}}" autocomplete="off"/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">{{ID Modbus}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Renseignez l'ID Modbus de la passerelle DTU hoymiles}}"></i></sup>
      </label>
      <div class="col-md-4">
        <input class="configKey form-control" data-l1key="id_modbus_dtu" placeholder="{{1}}" autocomplete="off"/>
      </div>
    </div>
    <!-- Exemple de champ de saisie du cron d'auto-actualisation avec assistant -->
		<!-- La fonction cron de la classe du plugin doit contenir le code prévu pour que ce champ soit fonctionnel -->
		<div class="form-group">
			<label class="col-sm-4 control-label">{{Auto-actualisation}}
					<sup><i class="fas fa-question-circle tooltips" title="{{Fréquence de rafraîchissement des commandes infos des micro-onduleurs}}"></i></sup>
			</label>
			<div class="col-sm-6">
				<div class="input-group">
					<input type="text" class="eqLogicAttr form-control roundedLeft" data-l1key="configuration" data-l2key="autorefresh" placeholder="{{Cliquer sur ? pour afficher l'assistant cron}}">
					<span class="input-group-btn">
				    <a class="btn btn-default cursor jeeHelper roundedRight" data-helper="cron" title="Assistant cron">
						  <i class="fas fa-question-circle"></i>
					  </a>
					</span>
				</div>
			</div>
		</div>
        <div class="form-group">
			<label class="col-lg-4 control-label">{{}}</label>
				
			<div class="col-lg-2">
                <a class="btn btn-success" id="bt_syncDtu" title="">
				<i class='fas fa-refresh' ></i> {{Synchroniser...}}</a>
			</div>
			<!--<div class="col-lg-2">
                <a class="btn btn-default" id="bt_connecthoymiles" title="!!! Sauvegarder avant...">
				<i class='fas fa-refresh' ></i> {{Connecter...}}</a>
			</div>
			-->
		</div>
    
  </fieldset>
</form>
<script>
	$('#bt_savePluginPanelConfig').on('click',function(){
		if($('.configKey[data-l1key=ip_dtu]').val() === ''){
				$('#div_alertPluginConfiguration').showAlert({message: 'IP invalide ! Renseignez l\'IP du DTU SVP' , level: 'warning'});
				$('#div_alertPluginConfiguration').removeClass('alert-success');
				$('#div_alertPluginConfiguration').addClass('alert-danger');
				return;
		}
		else if($('.configKey[data-l1key=port_dtu]').val() === ''){
				$('#div_alertPluginConfiguration').showAlert({message: 'Le champ Port utilisé ne peut être vide !' , level: 'warning'});
				$('#div_alertPluginConfiguration').removeClass('alert-success');
				$('#div_alertPluginConfiguration').addClass('alert-danger');
			return;
		}
		else if($('.configKey[data-l1key=id_modbus_dtu]').val() === ''){
				$('#div_alertPluginConfiguration').showAlert({message: 'Le champ ID Modbus ne peut être vide !' , level: 'warning'});
				$('#div_alertPluginConfiguration').removeClass('alert-success');
				$('#div_alertPluginConfiguration').addClass('alert-danger');
				return;
		}
        else if($('.configKey[data-l2key=autorefresh]').val() === ''){
				$('#div_alertPluginConfiguration').showAlert({message: 'Le champ Auto-actualisation ne peut être vide !' , level: 'warning'});
				$('#div_alertPluginConfiguration').removeClass('alert-success');
				$('#div_alertPluginConfiguration').addClass('alert-danger');
				return;
		}
	
	
	
	});

	
	$("input[data-l1key='functionality::cron::enable']").on('change',function(){
        if ($(this).is(':checked')) 
			$("input[data-l1key='functionality::cron5::enable']").prop("checked", false)
	 });

    $("input[data-l1key='functionality::cron5::enable']").on('change',function(){
        if ($(this).is(':checked')) 
			$("input[data-l1key='functionality::cron::enable']").prop("checked", false)
    });
	
	
	/////////////////////
	$('#bt_savePluginConfig').on('click',function(){
			if($('.configKey[data-l1key=ip_dtu]').val() === ''){
				$('#div_alertPluginConfiguration').showAlert({message: 'IP invalide ! Renseignez l\'IP du DTU SVP' , level: 'warning'});
				$('#div_alertPluginConfiguration').removeClass('alert-success');
				$('#div_alertPluginConfiguration').addClass('alert-danger');
				return;
            }
            else if($('.configKey[data-l1key=port_dtu]').val() === ''){
                    $('#div_alertPluginConfiguration').showAlert({message: 'Le champ Port utilisé ne peut être vide !' , level: 'warning'});
                    $('#div_alertPluginConfiguration').removeClass('alert-success');
                    $('#div_alertPluginConfiguration').addClass('alert-danger');
                return;
            }
            else if($('.configKey[data-l1key=id_modbus_dtu]').val() === ''){
                    $('#div_alertPluginConfiguration').showAlert({message: 'Le champ ID Modbus ne peut être vide !' , level: 'warning'});
                    $('#div_alertPluginConfiguration').removeClass('alert-success');
                    $('#div_alertPluginConfiguration').addClass('alert-danger');
                    return;
            }
            else if($('.configKey[data-l2key=autorefresh]').val() === ''){
                    $('#div_alertPluginConfiguration').showAlert({message: 'Le champ Auto-actualisation ne peut être vide !' , level: 'warning'});
                    $('#div_alertPluginConfiguration').removeClass('alert-success');
                    $('#div_alertPluginConfiguration').addClass('alert-danger');
                    return;
            }
	})
/* ******************************************************************* */
	$('#bt_syncDtu').on('click', function (){	
			if($('.configKey[data-l1key=ip_dtu]').val() === ''){
				$('#div_alertPluginConfiguration').showAlert({message: 'IP invalide ! Renseignez l\'IP du DTU SVP' , level: 'warning'});
				$('#div_alertPluginConfiguration').removeClass('alert-success');
				$('#div_alertPluginConfiguration').addClass('alert-danger');
				return;
            }
            else if($('.configKey[data-l1key=port_dtu]').val() === ''){
                    $('#div_alertPluginConfiguration').showAlert({message: 'Le champ Port utilisé ne peut être vide !' , level: 'warning'});
                    $('#div_alertPluginConfiguration').removeClass('alert-success');
                    $('#div_alertPluginConfiguration').addClass('alert-danger');
                return;
            }
            else if($('.configKey[data-l1key=id_modbus_dtu]').val() === ''){
                    $('#div_alertPluginConfiguration').showAlert({message: 'Le champ ID Modbus ne peut être vide !' , level: 'warning'});
                    $('#div_alertPluginConfiguration').removeClass('alert-success');
                    $('#div_alertPluginConfiguration').addClass('alert-danger');
                    return;
            }
            else if($('.configKey[data-l2key=autorefresh]').val() === ''){
                    $('#div_alertPluginConfiguration').showAlert({message: 'Le champ Auto-actualisation ne peut être vide !' , level: 'warning'});
                    $('#div_alertPluginConfiguration').removeClass('alert-success');
                    $('#div_alertPluginConfiguration').addClass('alert-danger');
                    return;
            }
			else{
				$('#div_alertPluginConfiguration').removeClass('alert-success');
              	$('#div_alertPluginConfiguration').removeClass('alert-danger');
              	$('#div_alert').empty();
              	$('#bt_savePluginConfig').trigger('click');
				$.ajax({
					type: "POST",
						url: "plugins/hoymiles/core/ajax/hoymiles.ajax.php",
						data: { action: "syncData",},
						dataType: 'json',
						error: function (request, status, error) {
							handleAjaxError(request, status, error);
						},
						success: function (data) {
							if (data.state != 'ok') {//erreur api
								if (data.result != 'bad request') {
									$('#div_alert').showAlert({message: '{{Echec de la tentative de connexion: }}' + data.result, level: 'danger'});
									$('#div_alertPluginConfiguration').append('<br>Echec de connexion. Vérifier que les informations saisies sont correctes. Msg: ' + data.result);
									$('#div_alertPluginConfiguration').removeClass('alert-success');
									$('#div_alertPluginConfiguration').addClass('alert-danger');
								}else{ //pas de reponse api
									$('#div_alert').showAlert({message: '{{Echec de la tentative de connexion: }}' + data.result , level: 'danger'});
									$('#div_alertPluginConfiguration').append('<br>Echec de connexion. Vérifier la connectivité internet. No response' );
									$('#div_alertPluginConfiguration').removeClass('alert-success');
									$('#div_alertPluginConfiguration').addClass('alert-danger');

								}
								return;
							}
							setTimeout(function() {window.location.reload();}, 2000);
							$('#div_alertPluginConfiguration').append('<br>Bravo!.. Synchronisation '  + ' - ' + data.result);//+ data.state
							$('#div_alert').showAlert({message: 'Actualiser la page ! (F5)', level: 'success'});
						}
				});
			}
	});
	
	

</script>