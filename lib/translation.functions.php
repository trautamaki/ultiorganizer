<?php

function U_($name)
{
	$translated = translate($name, $_SESSION['dbtranslations']);
	return $translated[$name];
}

function loadDBTranslations($database, $locale)
{
	$query = sprintf(
		"select translation_key, translation as value from uo_translation WHERE `locale`='%s'",
		$database->RealEscapeString(str_replace(".", "_", $locale))
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die("Failed to load translations for locale " . $locale . "\n" . $database->GetConnection()->error());
	}

	$_SESSION['dbtranslations'] = array();
	while ($translation = $database->FetchAssoc($result)) {
		$_SESSION['dbtranslations'][strtolower($translation['translation_key'])] = $translation['value'];
	}
}

function GetTranslations($database)
{
	if (isset($_GET['search']))
		$search = $_GET['search'];
	elseif (isset($_GET['query']))
		$search = $_GET['query'];
	else
		$search = $_GET['q'];
	if (isset($_GET['autocomplete']) && "true" == $_GET['autocomplete']) {
		return AllTranslations($database, $search, true);
	} else {
		return AllTranslations($database, $search, false);
	}
}

function GetAutocompleteTranslations($database)
{
	if (isset($_GET['search']))
		$search = $_GET['search'];
	elseif (isset($_GET['query']))
		$search = $_GET['query'];
	else
		$search = $_GET['q'];

	return AllTranslations($database, $search, true);
}

function AllTranslations($database, $search, $autocomplete = false)
{
	global $locales;
	$splitted = preg_split(WORD_DELIMITER, $search, -1, PREG_SPLIT_NO_EMPTY);
	$translation_arrays = array();
	$results = array();
	foreach ($locales as $loc => $name) {
		$loc = str_replace(".", "_", $loc);
		$results[$loc] = "";
		$query = sprintf("SELECT translation_key, translation FROM uo_translation
          WHERE locale='%s' AND (", $database->RealEscapeString($loc));

		$first = true;
		foreach ($splitted as $nextkey) {
			if ($first) {
				$first = false;
			} else {
				$query .= " OR ";
			}
			$query .= " translation_key like '" . $database->RealEscapeString($nextkey) . "%'";
		}
		$query .= ")";
		$answer = $database->DBQuery($query);
		$translations = array();
		while ($row = $database->FetchAssoc($answer)) {
			$translations[$row['translation_key']] = $row['translation'];
		}
		$translation_arrays[$loc] = $translations;
	}

	foreach ($translation_arrays as $lang => $translation_array) {
		if ($autocomplete) {
			$results[$lang] = autocompleteTranslate($search, $translation_array);
		} else {
			$results[$lang] = translate($search, $translation_array);
		}
	}
	$found = false;
	foreach ($results as $lang => $translations) {
		$flipped = array_flip($translations);
		if (isset($flipped[$search])) {
			$found = true;
		}
	}
	if (!$found) {
		$results[_("None")] = array($search => $search);
	}
	return $results;
}

function Translations($database)
{
	if (hasTranslationRight()) {
		$query = "SELECT * FROM uo_translation ORDER BY translation_key ASC";
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		return $result;
	} else {
		die('Insufficient rights to get translations');
	}
}

function SetTranslation($database, $key, $translations)
{
	if (hasTranslationRight()) {
		foreach ($translations as $locale => $value) {
			$locale = str_replace(".", "_", $locale);
			if (empty($value)) {
				$query = sprintf(
					"DELETE FROM uo_translation 
            WHERE translation_key = '%s' AND locale='%s'",
					$database->RealEscapeString($key),
					$database->RealEscapeString($locale)
				);
				$database->DBQuery($query);
			} else {
				$query = sprintf(
					"UPDATE uo_translation SET translation='%s' WHERE locale='%s' AND translation_key='%s'",
					$database->RealEscapeString($value),
					$database->RealEscapeString($locale),
					$database->RealEscapeString($key)
				);
				$result = $database->DBQuery($query);
				if (!$result) {
					die('Invalid query: ' . $database->GetConnection()->error());
				}
			}
		}
	} else {
		die('Insufficient rights to change translation');
	}
}

function AddTranslation($database, $key, $translations)
{
	if (hasTranslationRight()) {
		foreach ($translations as $locale => $value) {
			$locale = str_replace(".", "_", $locale);
			if (empty($value)) {
				$query = sprintf(
					"DELETE FROM uo_translation 
            WHERE translation_key = '%s' AND locale='%s'",
					$database->RealEscapeString($key),
					$database->RealEscapeString($locale)
				);
				$database->DBQuery($query);
			} else {
				$query = sprintf(
					"INSERT INTO uo_translation (translation_key, locale, translation)
	      VALUES ('%s', '%s', '%s')",
					$database->RealEscapeString($key),
					$database->RealEscapeString($locale),
					$database->RealEscapeString($value)
				);
				$result = $database->DBQuery($query);
				if (!$result) {
					die('Invalid query: ' . $database->GetConnection()->error());
				}
			}
		}
	} else {
		die('Insufficient rights to add translation');
	}
}

function RemoveTranslation($database, $key)
{
	if (hasTranslationRight()) {
		$query = sprintf(
			"DELETE FROM uo_translation WHERE translation_key='%s'",
			$database->RealEscapeString($key)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
	} else {
		die('Insufficient rights to remove translation');
	}
}

function translate($name, $translation_array)
{
	$retArr = array();
	$ret = "";

	if (isset($translation_array[strtolower($name)])) {
		$retArr[$name] = $translation_array[strtolower($name)];
		return $retArr;
	} else {
		$ret = "";
		$splitted = preg_split(WORD_DELIMITER, $name, -1, PREG_SPLIT_NO_EMPTY + PREG_SPLIT_DELIM_CAPTURE);
		foreach ($splitted as $part) {
			if (preg_match(WORD_DELIMITER, $part)) {
				$ret .= $part;
			} else {
				if (isset($translation_array[strtolower($part)])) {
					$ret .= $translation_array[strtolower($part)];
				} else {
					$ret .= $part;
				}
			}
		}
		$retArr[$name] = $ret;
		return $retArr;
	}
}

function autocompleteTranslate($name, $translation_array)
{
	$ret = array();
	foreach ($translation_array as $key => $translation) {
		if (strpos($key, strtolower($name)) === 0) {
			if (strlen($key) > strlen($name)) {
				$retName = $name . substr($key, strlen($name) - strlen($key));
			} else {
				$retName = $name;
			}
			$ret[$retName] = $translation;
		}
	}

	$splitted = preg_split(WORD_DELIMITER, $name, -1, PREG_SPLIT_NO_EMPTY);
	if (count($splitted) > 1) {
		$splitted = preg_split(WORD_DELIMITER, $name, -1, PREG_SPLIT_NO_EMPTY + PREG_SPLIT_DELIM_CAPTURE);

		$final = "";
		$finalkey = "";
		$lastpart = "";
		$lastkey = "";
		$current = "";
		$currentkey = "";
		$pending_delims = "";
		foreach ($splitted as $part) {
			if (preg_match(WORD_DELIMITER, $part)) {
				$pending_delims .= $part;
			} else {
				$current = $lastpart;
				$lastpart = $part;
				if (isset($translation_array[strtolower($current)])) {
					$final .= $translation_array[strtolower($current)];
				} else {
					$final .= $current;
				}
				$finalkey .= $current;
				$final .= $pending_delims;
				$finalkey .= $pending_delims;
				$pending_delims = "";
			}
		}
		$matchFound = false;
		foreach ($translation_array as $key => $translation) {
			if (strpos($key, strtolower($lastpart)) === 0) {
				$matchFound = true;
				if (strlen($key) > strlen($lastpart)) {
					$retName = $finalkey . $lastpart . substr($key, strlen($lastpart) - strlen($key)) . $pending_delims;
				} else {
					$retName = $finalkey . $lastpart . $pending_delims;
				}
				$retVal = $final . $translation . $pending_delims;
				if (strcasecmp($retVal, $name) != 0) {
					$ret[$retName] = $retVal;
				}
			}
		}
		if (!$matchFound) {
			$retName = $finalkey . $lastpart . $pending_delims;
			$retVal = $final . $lastpart . $pending_delims;
			if (strcasecmp($retVal, $name) != 0) {
				$ret[$retName] = $retVal;
			}
		}
	}
	return $ret;
}

function TranslatedField($fieldName, $value, $width = "200", $size = "30")
{
	return "
	<div style='width:" . $width . "px; height:20px' id='" . $fieldName . "Autocomplete' class='yui-skin-sam'>
		<input class='input' size='" . $size . "' maxlength='" . $size . "' style='width:" . $width . "px' id='" . $fieldName .
		"' name='" . $fieldName . "' value='" . utf8entities($value) . "'/>
		<div style='width:" . $width . "px' id='" . $fieldName . "Container'>
		</div>
	</div>\n";
}

function TranslationScript($fieldName)
{
	return "<script type=\"text/javascript\">
//<![CDATA[
var " . $fieldName . "SelectHandler = function(sType, aArgs) {
	var oData = aArgs[2];
	document.getElementById(\"" . $fieldName . "\").value = oData[1];
};

" . $fieldName . "Fetch = function(){        
	var translationSource = new YAHOO.util.XHRDataSource(\"ext/autocompletetranslationtxt.php\");
    translationSource.responseSchema = {
         recordDelim: \"\\n\",
         fieldDelim: \"\\t\"
    };
    translationSource.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
    translationSource.maxCacheEntries = 60;

    // First AutoComplete
    var translationAutoComp = new YAHOO.widget.AutoComplete(\"" . $fieldName . "\",\"" . $fieldName . "Container\", translationSource);
    translationAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) { 

    	// some other piece of data defined by schema 
		var translated = oResultData[2];  
		var completed = oResultData[1];
		var fill = completed.substring(sQuery.length);
		var aMarkup = [\"<div class='myCustomResult'>\", 
		sQuery, 
		\"<span style='font-weight:bold'>\", 
		fill, 
		\" &raquo; </span>\",
		sResultMatch,
		\": \", 
		translated, 
		\"</div>\"]; 
		return (aMarkup.join(\"\"));
	}; 
	translationAutoComp.itemSelectEvent.subscribe(" . $fieldName . "SelectHandler);
    return {
        oDS: translationSource,
        oAC: translationAutoComp
    }
}();
//]]>
</script>";
}
