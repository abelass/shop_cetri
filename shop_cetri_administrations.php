<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin shop_cetri
 *
 * @plugin     shop_cetri
 * @copyright  2014
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Shop_cetri\Installation
 */
if (! defined('_ECRIRE_INC_VERSION'))
	return;

/**
 * Fonction d'installation et de mise à jour du plugin shop_cetri.
 *
 * Vous pouvez :
 *
 * - créer la structure SQL,
 * - insérer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre à jour la structure SQL
 *
 * @param string $nom_meta_base_version
 *        	Nom de la meta informant de la version du schéma de données du
 *        	plugin installé dans SPIP
 * @param string $version_cible
 *        	Version du schéma de données dans ce plugin (déclaré dans
 *        	paquet.xml)
 * @return void
 *
 */
function shop_cetri_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	$maj['1.0.1'] = array(
		array(
			'sql_alter',
			'TABLE spip_articles CHANGE prix_livre prix float (38,2) NOT NULL'
		)
	);

	$maj['2.0.0'] = array(
		array(
			'convertir_prix'
		),
		array(
			'sql_alter',
			'TABLE spip_articles DROP COLUMN prix'
		),
		array(
			'maj_tables',
			array(
				'spip_articles',
				'spip_commandes'
			)
		)
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Fonction de désinstallation du plugin shop_cetri.
 *
 * Vous devez :
 *
 * - nettoyer toutes les données ajoutées par le plugin et son utilisation
 * - supprimer les tables et les champs créés par le plugin.
 *
 * @param string $nom_meta_base_version
 *        	Nom de la meta informant de la version du schéma de données du
 *        	plugin installé dans SPIP
 * @return void
 *
 */
function shop_cetri_vider_tables($nom_meta_base_version) {
	effacer_meta($nom_meta_base_version);
}

/**
 * Convertir les prix contenus dans le camps extras prix/article en prix objet
 * avec la déclinaison
 * "Version papier"
 */
function convertir_prix() {
	include_spip('inc/editer');
	$declinaisons = array(
		'Version papier',
		'EPUB',
		'PDF'
	);

	foreach ($declinaisons as $titre) {
		set_request('titre', $titre);
		set_request('statut', 'publie');
		$declinaisons[$titre] = formulaires_editer_objet_traiter('declinaison',
				'new');
	}

	$titre_declinaison_defaut = $declinaisons[0];

	$sql = sql_select('prix,id_article,titre', 'spip_articles', 'prix > 0');

	while ($data = sql_fetch($sql)) {

		$titre = supprimer_numero($data['titre']);
		$titre_secondaire = $titre_declinaison_defaut;

		$titre = $titre . ' - ' . $titre_secondaire;

		// On inscrit dans la bd
		$valeurs = array(
			'id_declinaison' => $declinaisons[$titre_declinaison_defaut]['id_declinaison'],
			'id_objet' => $data['id_article'],
			'objet' => 'article',
			'code_devise' => 'EUR',
			'titre' => $titre,
			'prix' => $data['prix']
		);

		$prix_objets = sql_insertq('spip_prix_objets', $valeurs);
	}
}
