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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class ecowatt extends eqLogic {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*
	 * Fonction exécutée automatiquement toutes les minutes par Jeedom
	public static function cron() {

	}
	 */

	/*
	 * Fonction exécutée automatiquement toutes les heures par Jeedom	 */
	public static function cronHourly() {
		foreach (self::byType('ecowatt') as $ecowatt) {

		}
	}

	/*
	 * Fonction exécutée automatiquement tous les jours par Jeedom
	public static function cronDayly() {

	}
	 */

	/*     * *********************Méthodes d'instance************************* */

	public function postSave() {
		if ($this->getConfiguration('datasource') == 'ecowatt' || $this->getConfiguration('datasource') == 'ejp') {
			$today = $this->getCmd(null, 'today');
			if (!is_object($today)) {
				$today = new ecowattCmd();
				$today->setLogicalId('today');
				$today->setIsVisible(1);
				$today->setName(__('Aujourd\'hui', __FILE__));
				$today->setOrder(1);
			}
			$today->setType('info');
			$today->setSubType('string');
			$today->setEqLogic_id($this->getId());
			$today->setEventOnly(1);
			$today->save();

			$tomorrow = $this->getCmd(null, 'tomorrow');
			if (!is_object($tomorrow)) {
				$tomorrow = new ecowattCmd();
				$tomorrow->setLogicalId('tomorrow');
				$tomorrow->setIsVisible(1);
				$tomorrow->setName(__('Demain', __FILE__));
				$tomorrow->setOrder(2);
			}
			$tomorrow->setType('info');
			$tomorrow->setSubType('string');
			$tomorrow->setEqLogic_id($this->getId());
			$tomorrow->setEventOnly(1);
			$tomorrow->save();
		}
		if ($this->getConfiguration('datasource') == 'eco2mix') {
			$today = $this->getCmd(null, 'today');
			if (is_object($today)) {
				$today->remove();
			}
			$tomorrow = $this->getCmd(null, 'tomorrow');
			if (is_object($tomorrow)) {
				$tomorrow->remove();
			}
		}
	}

	public function updateInfo() {
		switch ($this->getConfiguration('datasource')) {
			case 'ecowatt':
				switch ($this->getConfiguration('region-ew')) {
					case 'bretagne':

						break;

					case 'paca':
						$request_http = new com_http('http://www.ecowatt-paca.fr/restez-au-courant/alertes-2/');
						$data = $request_http->exec();
						echo $data;
						break;
				}
				break;
			case 'ejp':
				# code...
				break;
			case 'eco2mix':
				# code...
				break;
		}
	}

	/*
	 * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
	public function toHtml($_version = 'dashboard') {

	}
	 */

	/*     * **********************Getteur Setteur*************************** */
}

class ecowattCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */

	/*
	 * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
	public function dontRemoveCmd() {
	return true;
	}
	 */

	public function execute($_options = array()) {

	}

	/*     * **********************Getteur Setteur*************************** */
}

?>
