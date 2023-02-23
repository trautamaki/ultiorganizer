<?php
/**
 * The block content is the text that should be DB translated.
 *
 * @param array $params
 * @param string $text
 * @see http://www.smarty.net/docs/en/plugins.block.functions.tpl
 * @return string
 */
function smarty_block_u($params, $text) {
	if (!isset($text)) {
		return $text;
	}
    
    $text = utf8entities($text);

	$translated = translate($text, $_SESSION['dbtranslations']);
	return $translated[$text];
}
