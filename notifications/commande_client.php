<?php
/**
 * Fonction du plugin Commandes
 *
 * @plugin     Commandes
 * @copyright  2014
 * @author     Ateliers CYM, Matthieu Marcillaud, Les Développements Durables
 * @licence    GPL 3
 * @package    SPIP\Commandes\Notifications
 */

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

function notifications_commande_client_dist($quoi, $id_commande, $options) {
	spip_log('commande gener cetr', 'teste');
	spip_log($quoi, 'teste');
	spip_log($id_commande, 'teste');
	spip_log($options, 'teste');

	$o['pieces_jointes'][] = array(
		'chemin' => $chemin,
		'nom' => $nom,
		'encodage' => 'base64',
		'mime' => $doc['mime_type']
	);

	$corps = array(
		'html' => 'teste conteu',
		'pieces_jointes' => array(
			array(
				'chemin' => 'sites/cetri/IMG/pdf/collin_de_plancy_berthe_au_grand_pied.pdf',
				'nom' => $nom,
				'encodage' => 'base64',
				'mime' => $doc['mime_type']
			),
		),
	);

	$envoyer_mail = charger_fonction('envoyer_mail', 'inc/');
	return $envoyer_mail('abelass2@websimple.be', 'teste', $corps);

}

/**
 * Détermine le client destinataire des notifications d'une commande
 *
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array $options
 *     options
 * @return array
 *     Liste des destinataires
 */
function notifications_commande_client_destinataires_dist($id_commande, $options) {
	$id_auteur=sql_getfetsel("id_auteur","spip_commandes","id_commande=".$id_commande);
	return array($id_auteur);
}

?>
