<?php
/**
 * Utilisations du cron par Shop cetr
 *
 * @plugin     Shop Cetri
 * @copyright  2017
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Shop_cetri\Genie
 */
if (!defined('_ECRIRE_INC_VERSION'))
	return;

/**
 * Vérifie s'il s'agit d'envoyer un nouveu fichier aux abbonnés.
 *
 * @param object $t
 * @return boolean
 */
function genie_shop_cetri_envoyer_abonnements_dist($t) {
	if (
			include_spip('inc/config')
			and $config = lire_config('commandes')
			and $quand = ($config['quand'] ? $config['quand'] : array())
			and $config['activer'] // les notifications sont activées
			and $envoyer_mail = charger_fonction('envoyer_mail', 'inc')
			) {

			// Déterminer l'expéditeur
			$options = array();
			if( $config['expediteur'] != "facteur" ) {
				$options['expediteur'] = $config['expediteur_'.$config['expediteur']];
			}
			$subject = _T('shop_cetri:votre_abonnement_sur', array('nom' => $GLOBALS['meta']['nom_site']));


			$date = date('Y-m-d H:i:s', time());

			$sql = sql_select('d.fichier,td.mime_type,d.extension,a.email,c.id_commande,c.dates_envoi',
					'spip_articles AS art LEFT JOIN
						spip_prix_objets AS po ON po.id_objet=art.id_article LEFT JOIN
						spip_declinaisons AS decl USING(id_declinaison) LEFT JOIN
						spip_commandes_details AS cd ON po.id_prix_objet=cd.id_objet LEFT JOIN
						spip_commandes AS c USING(id_commande) LEFT JOIN
						spip_auteurs AS a USING(id_auteur) LEFT JOIN
						spip_documents_liens AS dl ON art.id_article=dl.id_objet LEFT JOIN
						spip_documents AS d USING (id_document) LEFT JOIN
						spip_types_documents AS td USING(extension)',
					'art.page LIKE "abonnement" AND
						dl.objet LIKE "article" AND
						po.objet LIKE "article" AND
						c.statut LIKE "paye" AND
						decl.titre LIKE UPPER(d.extension) AND
						d.date > c.date_envoi AND
						DATE_ADD(c.date, INTERVAL 1 YEAR) >="' . $date .'"');
			while ($data = sql_fetch($sql)) {
				$options['id_commande'] = $data['id_commande'];
				$message = recuperer_fond('notifications/contenu_abonnement_mail', $options);
				$fichier = $data['fichier'];
				list($extension, $nom) = explode('/', $fichier);
				$chemin = realpath(_DIR_IMG . $fichier);
				$envoyer_mail($data['email'], $subject, array(
					'html' => $message,
					'pieces_jointes' => array(
						array(
							'chemin' => $chemin,
							'nom' => $nom,
							'encodage' => 'base64',
							'mime' => $data['mime_type'],
						),
					),
				));
			}
		}

	return 1;
}
