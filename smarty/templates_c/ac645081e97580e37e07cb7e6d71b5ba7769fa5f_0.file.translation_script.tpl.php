<?php
/* Smarty version 4.3.0, created on 2023-03-03 14:30:26
  from '/var/www/html/smarty/templates/translation_script.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401e8625da8b5_75580713',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac645081e97580e37e07cb7e6d71b5ba7769fa5f' => 
    array (
      0 => '/var/www/html/smarty/templates/translation_script.tpl',
      1 => 1677836823,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6401e8625da8b5_75580713 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
  var {
    $field_name
  }
  SelectHandler = function(sType, aArgs) {
      var oData = aArgs[2];
      document.getElementById("<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
").value = oData[1];
      };

      {
        $field_name
      }
      Fetch = function() {
        var translationSource = new YAHOO.util.XHRDataSource("ext/autocompletetranslationtxt.php");
        translationSource.responseSchema = {
          recordDelim: "\\n",
          fieldDelim: "\\t"
        };
        translationSource.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
        translationSource.maxCacheEntries = 60;

        // First AutoComplete
        var translationAutoComp = new YAHOO.widget.AutoComplete("<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
", "<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
Container", translationSource);
        translationAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) {
          // some other piece of data defined by schema 
          var translated = oResultData[2];
          var completed = oResultData[1];
          var fill = completed.substring(sQuery.length);
          var aMarkup = ["<div class='myCustomResult'>",
            sQuery,
            "<span style='font-weight:bold'>",
            fill,
            " &raquo; </span>",
            sResultMatch,
            ": ",
            translated,
            "</div>"
          ];
          return (aMarkup.join(""));
        };
        translationAutoComp.itemSelectEvent.subscribe({
            $field_name
          }
          SelectHandler);
        return {
          oDS: translationSource,
          oAC: translationAutoComp
        }
      }();
<?php echo '</script'; ?>
><?php }
}
