<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Cetri Shp
 * @author     Rainer Müller
 * @licence    GNU/GPL
 */
if (! defined('_ECRIRE_INC_VERSION'))
	return;

function shop_cetri_declarer_tables_principales($tables_principales) {

	$tables_principales['spip_articles'] = array(
		'field' => array('date_envoi_abonnement'=>"datetime NOT NULL DEFAULT '0000-00-00 00:00:00'"),
	);
	$tables_principales['spip_commandes'] = array(
		'field' => array('dates_envoi'=>"text NOT NULL"),
	);

	return $tables_principales;
}

/* champ extra shop -> pour la commande */
function inc_shop_cetri_shop_champs_extras ($flux) {
	$defaut = $flux['args'];

	$flux['data']['commande']['saisies'][] = array(
		'saisie' => 'oui_non', // Pour la configuration
		'formulaires' => array(
			'configuer_shop',
			'editer_client'
		),
		'tables' => array(
			'spip_commandes' => array(
				'field' => array(
					'newsletter' => "varchar(3) NOT NULL"
				)
			)
		),
		'options' => array(
			'li_class' => 'conditionnel',

			'nom' => 'commande_newsletter', // Pour la configuration
			'nom_2' => 'newsletter', // Pour le formulaire public
			'label' => _T('shop_cetri:label_inscrire_newsletter'),
			'defaut' => isset($defaut['commande_newsletter']) ? $defaut['commande_newsletter'] : ''
		)

	);
	$flux['data']['commande']['saisies'][] = array(
		'saisie' => 'oui_non',
		'formulaires' => array(
			'configuer_shop'
		),
		'options' => array(
			'li_class' => 'conditionnel last',
			'nom' => 'newsletter_obligatoire',
			'label' => _T('saisies:option_obligatoire_label'),
			'defaut' => isset($defaut['newsletter_obligatoire']) ? $defaut['newsletter_obligatoire'] : '',
			'afficher_si' => '@commande_newsletter@ == "on"'
		)
	);

	return $flux;
}
?>