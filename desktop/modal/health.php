<?php error_reporting(E_ALL);
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
/*
if (!isConnect('admin')) {
	throw new Exception('401 Unauthorized');
}
* */

//$eqLogics = nagraphs::byType('nagraphs');
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('hoymiles');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
//include_file('3rdparty', 'jquery.tablesorter/parsers/parser-network', 'js');
?>
<table class="table table-condensed table-bordered tablesorter tablesorter-bootstrap hasResizable table-striped hasFilters" id="table_update" style="margin-top: 5px;" role="grid">


<table class="table table-condensed table-bordered tablesorter tablesorter-bootstrap table-striped" id="table_healthsfrBox" style="margin-top: 5px;">	
  <thead>
		<tr>
			<th style="width : 200px">{{Onduleur}}</th>
			<th style="width : 80px">{{ID}}</th>
			<th style="width : 150px">{{Mac}}</th>
			<th style="width : 150px">{{ipAddress}}</th>
			
			<th style="width : 80px">{{Statut}}</th>
			<!--<th style="width : 80px">{{Etat}}</th>-->
			<th style="width : 200px">{{Dernière connexion}}</th>
  			<th style="width : 200px">{{Dernière déconnexionn}}</th>
			<th style="width : 200px">{{Dernière communication}}</th>
			<th style="width : 200px">{{Date création}}</th>
		</tr>
	</thead>
	<tbody>
	 <?php
	
foreach ($eqLogics as $eqLogic) {
	$type = $eqLogic->getConfiguration('type');
	if ($type == 'lan') {
		echo '<tr><td><span class="fas fa-plug " style="margin-right: 5px;"></span><a href="' . $eqLogic->getLinkToConfiguration() . '" style="text-decoration: none;">' . $eqLogic->getName(true) . '</a></td>';
	
	} else if ($type == 'wifi') {
		echo '<tr><td><span class="fas fa-wifi " style="margin-right: 5px;"></span><a href="' . $eqLogic->getLinkToConfiguration() . '" style="text-decoration: none;">' . $eqLogic->getName(true) . '</a></td>';
	}else {
		echo '<tr><td><span class="label label-danger" style="font-size : 1.2em"><a href="' . $eqLogic->getLinkToConfiguration() . '" style="color: red">' . $eqLogic->getName(true) . '</a></span></td>';
	
	} 
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getId() . '</span></td>';
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getLogicalId() . '</span></td>';
	echo '<td><span class="label label-info" style="font-size : 1em; width:105px !Important;">' . $eqLogic->getConfiguration('ip') . '</span></td>';
	
	
	if ($type == 'lan' || $type == 'wifi') {
		//$eqstatus = $eqLogic->getConfiguration('status');//
		$cmd = $eqLogic->getCmd(null, 'status');//$eqLogic->getCmd('null', 'status');
		$eqstatus = $cmd->execCmd();
		if ($eqstatus === 'online') {
			$state='<td><span class="label label-success" style="font-size : 1em; cursor : default;">' . $eqstatus. '</span></td>';
		}else{
			$state='<td><span class="label label-warning" style="font-size : 1em; cursor : default;">' . $eqstatus. '</span></td>';
		}
	}else{	$state='<td><span class="label" style="font-size : 1em; cursor : default;">' . '' . '</span></td>';
	}
	echo $state;
	
	/*$status = '<span class="label label-success" style="font-size : 1em; cursor : default;">{{OK}}</span>';
	if ($eqLogic->getStatus('state') == 'nok') {
		$status = '<span class="label label-danger" style="font-size : 1em; cursor : default;">{{NOK}}</span>';
	}
	echo '<td>' . $status . '</td>';
    */
	///
	$lastOnline='';
	if (!empty($eqLogic->getStatus('last_online'))) {
		$lastOnline = $eqLogic->getStatus('last_online')[0];
		$lastOnline = date('Y-m-d H:i:s', strtotime($lastOnline));
		echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $lastOnline . '</span></td>';
	}else echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . '' . '</span></td>';
	
  	$lastOffline='';
	if (!empty($eqLogic->getStatus('last_offline'))) {
		$lastOffline = $eqLogic->getStatus('last_offline')[0];
		$lastOffline = date('Y-m-d H:i:s', strtotime($lastOffline));
		echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $lastOffline . '</span></td>';
	}else echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . '' . '</span></td>';

	///
	$lastComm=$eqLogic->getStatus('lastCommunication');
	if ((time()-strtotime($lastComm)) > 60*60 ){
		echo '<td><span class="label label-danger" style="font-size : 1em; cursor : default;">' . $eqLogic->getStatus('lastCommunication') . '</span></td>';
	
	}elseif ((time()-strtotime($lastComm)) > 30*60 ){
		echo '<td><span class="label label-warning" style="font-size : 1em; cursor : default;">' . $eqLogic->getStatus('lastCommunication') . '</span></td>';
	
	}else{
		echo '<td><span class="label label-success" style="font-size : 1em; cursor : default;">' . $eqLogic->getStatus('lastCommunication') . '</span></td>';
	}
	///
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getConfiguration('createtime') . '</span></td>';
	echo '</tr>';


}

?>
	</tbody>
</table>



<script>
//initTableSorter();
jeedomUtils.initTableSorter() 
</script>