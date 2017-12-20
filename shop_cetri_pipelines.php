<?php
/**
 * Utilisations de pipelines par shop_cetri
 *
 * @plugin     shop_cetri
 * @copyright  2014
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Shop_cetri\Pipelines
 */
if (!defined('_ECRIRE_INC_VERSION'))
	return;

/**
 * Ajouter des informations dans le head.
 *
 * @param string $flux
 * @return string
 */
function shop_cetri_insert_head($flux) {
	$css = find_in_path('css/shop_cetri.css');
	$flux .= "<link rel='stylesheet' type='text/css' media='all' href='$css' />\n";

	return $flux;
}

/**
 * Déclencher le cron si prévu dans la configuration
 *
 * @param array $taches
 *        la liste des tâches.
 *
 * @return array $taches
 *        la liste des tâches.
 */
function shop_cetri_taches_generales_cron($taches) {

	$periodicite = 24 * 3600;

	$taches['shop_cetri_envoyer_abonnements'] = $periodicite;

	return $taches;
}
