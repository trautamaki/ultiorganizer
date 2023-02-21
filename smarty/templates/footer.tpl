            </div><!--content-->
          </td>
        </tr>
      </table>
    </div><!--page_middle-->
    {if $enable_facebook}
    <script src='http://connect.facebook.net/en_US/all.js'></script>
    <script>
      FB.init({
        appId: '{$fb_app_id}',
        status: true,
        cookie: true,
        xfbml: true
      });
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    </script>
    {/if}
    <div class='page_bottom'></div>
    </div>
  </body>
</html>