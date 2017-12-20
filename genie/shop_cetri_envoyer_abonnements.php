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
	$date = date('Y-m-d H:i:s', time());
	$article_abonnement = sql_fetsel('date_envoi_abonnement,id_article', 'spip_articles', 'page LIKE "abonnement"');
	$id_article = $article_abonnement['id_article'];
	$date_envoi_abonnement = $article_abonnement['date_envoi_abonnement'];

	$sql = sql_select('d.fichier,td.mime_type,d.extension',
			'spip_documents_liens AS dl LEFT JOIN spip_documents AS d USING (id_document) LEFT JOIN spip_types_documents AS td USING(extension)',
			'dl.objet LIKE "article" AND dl.id_objet=' . $id_article . ' AND d.date > "' . $date_envoi_abonnement . '"');

	while ($documents = sql_fetch($sql)) {
		spip_log($documents, 'teste');
		$itre_declinaison = strtoupper($documents['extension']);
		$sql = sql_select(
				'a.email',
				'spip_declinaisons AS d LEFT JOIN
					spip_prix_objets AS po USING(id_declinaison) LEFT JOIN
					spip_commandes_details AS cd ON po.id_prix_objet=cd.id_objet LEFT JOIN
					spip_commandes AS c USING(id_commande) LEFT JOIN
					spip_auteurs AS a USING(id_auteur)',
				'd.titre LIKE' .sql_quote($itre_declinaison) . ' AND
					po.objet LIKE "article" AND
					po.id_objet=' . $id_article . ' AND
					DATE_ADD(c.date, INTERVAL 1 YEAR) >="' . $date .'"'
				);
		while ($donnees_commandes = sql_fetch($sql)) {
			spip_log($donnees_commandes, 'teste');
		}
	}

	return 1;
}