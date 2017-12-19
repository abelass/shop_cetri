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

function notifications_commande_client_contenu_dist($id_commande, $options, $destinataire, $mode) {
	$donnees_objet = sql_fetsel('id_objet, objet', 'spip_commandes_details', 'id_commande=' . $id_commande);
	if ($donnees_objet['objet'] == 'prix_objet') {
		$donnes_prix = sql_fetsel(
				'po.objet,po.id_objet,d.titre',
				'spip_prix_objets AS po LEFT JOIN spip_declinaisons AS d USING(id_declinaison)',
				'po.id_prix_objet=' .$donnees_objet['id_objet']);

		$titre = strtolower($donnes_prix['titre']);
		$doc = sql_fetsel('*',
				'spip_documents_liens LEFT JOIN spip_documents USING (id_document) LEFT JOIN spip_types_documents USING(extension)',
				'objet LIKE' . sql_quote($donnes_prix['objet']) . ' AND id_objet=' . $donnes_prix['id_objet'] . ' AND extension LIKE ' . sql_quote($titre));
		$fichier = $doc['fichier'];
		list($extension, $nom) = explode('/', $fichier);
		$chemin = realpath(_DIR_IMG . $fichier);

		$corps = array(
			'pieces_jointes' => array(
				array(
					'chemin' => $chemin,
					'nom' => $nom,
					'encodage' => 'base64',
					'mime' => $doc['mime_type']
				),
			),
		);

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
function notifications_commande_client_destinataires_dist($id_commande, $options) {
	$id_auteur=sql_getfetsel("id_auteur","spip_commandes","id_commande=".$id_commande);
	return array($id_auteur);
}

?>
