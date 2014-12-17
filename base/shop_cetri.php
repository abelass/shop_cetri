<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Sh013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;




// Ajout de champs extras
function shop_cetri_declarer_champs_extras($champs = array()) {

	$champs['spip_articles']['lang'] = array(

			'saisie' => 'input',//Type du champ (voir plugin Saisies)

			'options' => array(
					'nom' => 'prix',
					'label' => _T('prix'),
					'sql' => "float (38,2) NOT NULL",
					'defaut' => '',// Valeur par défaut
				),

	);

	return $champs;

}
?>