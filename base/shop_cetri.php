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

/*champ extra shop -> pour la commande*/
function shop_cetri_shop_champs_extras($flux) {
	$defaut=$flux['args'];
	$flux['data']['commande']['saisies'][]=
		array(
                    'saisie' => 'oui_non',// Pour la configuration               
                    'formulaires' => array('configuer_shop','editer_client'),
                    'tables'=>array(
                        'spip_commandes'=>array(
                            'field'=>array(
                                'newsletter'=>"varchar(3) NOT NULL"
                                )
                             )
                        ),
                    'options' => array(
                        'li_class'=>'conditionnel',

                        'nom' => 'commande_newsletter',// Pour la configuration
                        'nom_2' => 'newsletter',// Pour le formulaire public                          
                        'label' => _T('shop_cetri:label_inscrire_newsletter'),
                        'defaut' => isset($defaut['commande_newsletter'])?$defaut['commande_newsletter']:'',

                    )

	 
                );
	$flux['data']['commande']['saisies'][]=
		                array(
                    'saisie' => 'oui_non',
                    'formulaires' => array('configuer_shop'),
                    'options' => array(
                        'li_class'=>'conditionnel last',
                        'nom' => 'newsletter_obligatoire',
                        'label' => _T('saisies:option_obligatoire_label'),
                        'defaut' => isset($defaut['newsletter_obligatoire'])?$defaut['newsletter_obligatoire']:'',
                        'afficher_si' => '@commande_newsletter@ == "on"',
                    )
                );
				
	return $flux;
}
?>