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

if (!defined('_ECRIRE_INC_VERSION')) return;

function shop_cetri_insert_head($flux) {
	$css = find_in_path('css/shop_cetri.css');
	$flux .= "<link rel='stylesheet' type='text/css' media='all' href='$css' />\n";

	return $flux;
}
