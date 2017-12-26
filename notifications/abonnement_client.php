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

/**
 * Ajoute le document correspondant à la commande
 *
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array $options
 *     options
 * @param array $destinataires
 *     les destinataires
 * @param string $mode
 *     le mode e'envoi
 *
 * @return array
 *     Le contenu additionel
 */
function notifications_abonnement_client_contenu_dist($id_commande, $options, $destinataire, $mode) {
	if (isset($options['pieces_jointes'])) {
		$options['id_commande'] = $id_commande;
		$corps['texte'] = html_entity_decode(recuperer_fond('notifications/abonnement_client_texte', $options),ENT_HTML5);
		$corps['pieces_jointes'] = $options['pieces_jointes'];
		return $corps;
	}
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
function notifications_abonnement_client_destinataires_dist($id_commande, $options) {
	spip_log('tdest', 'teste');
	$id_auteur=sql_getfetsel("id_auteur","spip_commandes","id_commande=".$id_commande);
	spip_log($id_auteur, 'teste');
	return array($id_auteur);
}
