<?php
/**
 * Metadata for configuration manager plugin
 * Additions for the pgn4web plugin
 *
 * @license    GPL 3 (http://www.gnu.org/licenses/gpl.html)
 * @author     Michael Arlt <michael.arlt [at] sk-schwanstetten [dot] de>
 */

$meta['set'] = array('multichoice','_choices' => array('alpha (png)','merida (png)','uscf (png)','igorsvg','svgchess','tilesvg'));
$meta['setsizeportrait'] = array('numeric', '_min'=>16, '_max'=>500);
$meta['setsizelandscape'] = array('numeric', '_min'=>16, '_max'=>500);
$meta['pluginwidthportrait'] = array('string');
$meta['pluginwidthlandscape'] = array('string');
$meta['font'] = array('multichoice','_choices' => array('ChessSansAlpha','ChessSansMerida','ChessSansPiratf','ChessSansUscf','ChessSansUsual'));
$meta['textheight'] = array('string');
$meta['infowidth'] = array('string');
$meta['layout'] = array('multichoice','_choices' => array('auto','landscape','portrait'));
$meta['showsetselect'] = array('onoff');
$meta['showfontselect'] = array('onoff');
$meta['err_instance'] = array('');
$meta['err_instance_author'] = array('');


//Setup VIM: ex: et ts=2 :

