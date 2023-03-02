<script type="text/javascript">
  var {
    $field_name
  }
  SelectHandler = function(sType, aArgs) {
      var oData = aArgs[2];
      document.getElementById("{$field_name}").value = oData[1];
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
        var translationAutoComp = new YAHOO.widget.AutoComplete("{$field_name}", "{$field_name}Container", translationSource);
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
</script>