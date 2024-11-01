<?php
global $wp_version;

/******************************************************************/

function wpsh_init(){
        include( WPSH_PATH . '/content/top.php');
        include( WPSH_PATH . '/content/middle.php');
        include( WPSH_PATH . '/content/bottom.php');
}

/******************************************************************/

/*Vérifier si URL temporaire*/
function wpsh_check_temporary_url(){
  $tempoUrl = get_home_url();
  $tempoUrlMessage = '<div class="wps-tempo-url">Attention, vous utilisez actuellement une URL temporaire, sachez que le cache n\'est pas actif dessus. <a href="https://www.wpserveur.net/wpserveur-domaines-et-adresses-email/" target="blank" class="wps-tempo-url-btn">Comment obtenir un nom de domaine</a></div>';
  if(preg_match('#[.]pf[0-9][.]wpserveur\.net$#' ,$tempoUrl)){
    echo $tempoUrlMessage;
  }
}

/* Vérification des mises à jour */
function wpsh_updateWp() {
  global $wp_version;
  global $wps_wp_latest;
	$update_wp = wp_get_update_data();

	$wordpress = $update_wp['counts']['wordpress'];

	if($wordpress < 1) {
    echo '<div class="wps-updates wps-border-green"><div class="wps-up-left"><span class="dashicons dashicons-thumbs-up wps-icon-green"></span> Bravo, votre <strong>WordPress</strong> est à jour ! <span class="wps-info-ok">' . $wp_version . '</span></div><div class="wps-up-right"><a class="wps-h-btn-disabled"><span class="dashicons dashicons-yes"></span> Aucune mise à jour disponible</a></div></div>';
	} else {
    echo '<div class="wps-updates wps-border-red"><div class="wps-up-left"><span class="dashicons dashicons-thumbs-down wps-icon-red"></span> Votre <strong>WordPress</strong> nécessite une mise à jour ! <span class="wps-info-error">' . $wp_version . '</span></div><div class="wps-up-right"><a href="/wp-admin/update-core.php" class="wps-h-btn-error"><span class="dashicons dashicons-warning"></span> Mise à jour disponible</a></div></div>';
	}
}
function wpsh_updatePlugins() {
	$update_plugins = wp_get_update_data();

	$plugins = $update_plugins['counts']['plugins'];

	if($plugins < 1) {
    echo '<div class="wps-updates wps-border-green"><div class="wps-up-left"><span class="dashicons dashicons-thumbs-up wps-icon-green"></span> Bravo, tous vos <strong>plugins</strong> sont à jour !</div><div class="wps-up-right"><a class="wps-h-btn-disabled"><span class="dashicons dashicons-yes"></span> Aucune mise à jour disponible</a></div></div>';
	} else {
    echo '<div class="wps-updates wps-border-red"><div class="wps-up-left"><span class="dashicons dashicons-thumbs-down wps-icon-red"></span> Un ou plusieurs de vos <strong>plugins</strong> nécessitent une mise à jour !</div><div class="wps-up-right"><a href="/wp-admin/plugins.php?plugin_status=upgrade" class="wps-h-btn-error"><span class="dashicons dashicons-warning"></span> Mise(s) à jour disponible(s)</a></div></div>';
	}
}
function wpsh_updateThemes() {
	$update_themes = wp_get_update_data();

	$themes = $update_themes['counts']['themes'];

	if($themes < 1) {
    echo '<div class="wps-updates wps-border-green"><div class="wps-up-left"><span class="dashicons dashicons-thumbs-up wps-icon-green"></span> Bravo, tous vos <strong>thèmes</strong> sont à jour !</div><div class="wps-up-right"><a class="wps-h-btn-disabled"><span class="dashicons dashicons-yes"></span> Aucune mise à jour disponible</a></div></div>';
	} else {
    echo '<div class="wps-updates wps-border-red"><div class="wps-up-left"><span class="dashicons dashicons-thumbs-down wps-icon-red"></span> Un ou plusieurs de vos <strong>thèmes</strong> nécessitent une mise à jour !</div><div class="wps-up-right"><a href="/wp-admin/update-core.php" class="wps-h-btn-error"><span class="dashicons dashicons-warning"></span> Mise(s) à jour disponible(s)</a></div></div>';
	}
}

/* Compter le nombre de plugins et afficher le contenu en conséquences */
function wpsh_numberPlugins() {

  $nbGood = 30;
  $nbPluginsTitle = "";
  $nbPluginsDesc = "";
  $nbPluginsBtn = "";
	$plugins = get_plugins();
  $plugActive = count(get_option('active_plugins'));
	$result = count($plugins);
  $plugInactive = ($result - $plugActive);

  /* Récupérer le nom des plugins inutilisés */
  function wpsh_get_inactive_plugin_array($active_plugins){
    $active_plugins = get_option('active_plugins');
      if ( ! function_exists( 'get_plugins' ) ) {
          require_once ABSPATH . 'wp-admin/includes/plugin.php';
      }

      $all_plugins = get_plugins();
      global $plugInactive;
      if($plugInactive !== "0"){
        echo '<div class="wps-list-inactive">';
          echo '<ul>';
          foreach($all_plugins as $plugin=>$version){
              if(!in_array($plugin, $active_plugins)) {
                  echo ' <li>' . $version['Name'] . '</li>';
              }
          }
          echo '</ul>';
        echo '</div>';
        echo '<script>';
          echo'jQuery(function ($) {';
            echo'$(".hoverPlugins").hover(function(){';
              echo'$(".wps-list-inactive").fadeToggle("fast");';
            echo'});';
          echo'});';
        echo '</script>';
      }
  }

  if($result < $nbGood) {
    global $active_plugins;
    global $listPluginsInactive;
    echo '<div class="wps-count-plugins wps-border-green">';
    if ($result == 0){
      $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous n'avez <strong>aucun plugin</strong> installé !</h3>";
      $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">C'est curieux, vous n'avez aucun plugin installé actuellement !<br> Est-ce une erreur de votre part ? Au moins votre site est optimal :)</p>";
      $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a class=\"wps-h-btn-disabled\"><span class=\"dashicons dashicons-yes\"></span> Aucun plugin installé actuellement</a></p>";
      $listPluginsInactive = "";
    }
    elseif ($result == 1){
      if($plugActive == 1){
        $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>un seul plugin</strong> installé et activé !</h3>";
        $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">C'est bien, vous n'avez qu'un seul plugin installé et activé actuellement !<br>Vous devez savoir que moins vous avez de plugins, plus votre site est rapide ! :)</p>";
        $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a class=\"wps-h-btn-disabled\"><span class=\"dashicons dashicons-yes\"></span> Aucun plugin inactif à supprimer</a></p>";
        $listPluginsInactive = "";
      }
      else {
        $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>un seul plugin</strong> installé !</h3>";
        $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous n'avez qu'un seul plugin installé et <strong>il n'est pas activé</strong> !<br>Pensez à <strong>supprimer les plugins inutilisés</strong> ! :)</p>";
        $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/plugins.php?plugin_status=inactive\" class=\"wps-h-btn-error hoverPlugins\"><span class=\"dashicons dashicons-warning\"></span> Supprimer le plugin inactif</a></p>";
        $listPluginsInactive = wps_get_inactive_plugin_array($active_plugins);
      }
    }
    else{
      if($plugInactive == 0){
        $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>" . $result . " plugins</strong> installés et activés !</h3>";
        $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous n'avez pas trop de plugins installés sur votre WordPress,  et aucun n'est inactif actuellement !<br>C'est très bien, vous avez pensé à <strong>supprimer les plugins inutilisés</strong> ! :)</p>";
        $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a class=\"wps-h-btn-disabled hoverPlugins\"><span class=\"dashicons dashicons-yes\"></span> Aucun plugin inactif à supprimer</a></p>";
      }
      elseif($plugInactive == 1){
        $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>" . $result . " plugins</strong> installés !</h3>";
        $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous n'avez pas trop de plugins installés sur votre WordPress,  et un seul est inactif actuellement !<br>Pensez à <strong>supprimer le plugin inutilisé</strong> ! :)</p>";
        $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/plugins.php?plugin_status=inactive\" class=\"wps-h-btn-error hoverPlugins\"><span class=\"dashicons dashicons-warning\"></span> Supprimer le plugin inactif</a></p>";
        $listPluginsInactive = wpsh_get_inactive_plugin_array($active_plugins);
      }
      else{
        $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>" . $result . " plugins</strong> installés !</h3>";
        $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous n'avez pas trop de plugins installés sur votre WordPress,  mais certains sont inactifs !<br>Pensez à <strong>supprimer les plugins inutilisés</strong> ! :)</p>";
        $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/plugins.php?plugin_status=inactive\" class=\"wps-h-btn-error hoverPlugins\"><span class=\"dashicons dashicons-warning\"></span> Supprimer les plugins inactifs <span class=\"wps-info\">" . $plugInactive . "</span></a></p>";
        $listPluginsInactive = wps_get_inactive_plugin_array($active_plugins);
      }
      echo $nbPluginsTitle;
      echo '<div class="nbPluginsContent">';
      echo $nbPluginsDesc;
      echo $nbPluginsBtn;
      echo $listPluginsInactive;
      echo '</div>';
      echo '</div>';
		}
  }
  else{
    echo '<div class="wps-count-plugins wps-border-red">';
    if($plugInactive == 0){
      $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>" . $result . " plugins</strong> installés !</h3>";
      $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous avez beaucoup de plugins installés sur votre WordPress,  et aucun n'est inactif actuellement ! Nous vous conseillons de <strong>supprimer quelques plugins</strong> ! :)</p>";
      $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/plugins.php\" class=\"wps-h-btn-error\"><span class=\"dashicons dashicons-warning\"></span> Supprimer quelques plugins</a></p>";
    }
    elseif($plugInactive == 1){
      $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>" . $result . " plugins</strong> installés !</h3>";
      $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous avez beaucoup de plugins installés sur votre WordPress,  et un seul est inactif actuellement ! Pensez à <strong>supprimer quelques plugins ainsi que celui inutilisé</strong> ! :)</p>";
      $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/plugins.php\" class=\"wps-h-btn-error\"><span class=\"dashicons dashicons-warning\"></span> Supprimer des plugins dont celui inactif</a></p>";
    }
    else{
      $nbPluginsTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>" . $result . " plugins</strong> installés !</h3>";
      $nbPluginsDesc = "<p class=\"nbPluginsDescBloc\">Vous avez beaucoup de plugins installés sur votre WordPress,  et certains sont inactifs ! Pensez à <strong>supprimer quelques plugins ainsi que ceux inutilisés</strong> ! :)</p>";
      $nbPluginsBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/plugins.php\" class=\"wps-h-btn-error\"><span class=\"dashicons dashicons-warning\"></span> Supprimer des plugins dont ceux inactifs <span class=\"wps-info\">" . $plugInactive . "</span></a></p>";
      $listPluginsInactive = wps_get_inactive_plugin_array($active_plugins);
    }
    echo $nbPluginsTitle;
    echo '<div class="nbPluginsContent">';
    echo $nbPluginsDesc;
    echo $nbPluginsBtn;
    echo '</div>';
    echo '</div>';
	}
}

/* Compter le nombre de thèmes et afficher le contenu en conséquences */

function wpsh_numberThemes() {

	$nbTGood = 2;
  $nbThemesTitle = "";
  $nbThemesDesc = "";
  $nbThemesBtn = "";
	$themes = wp_get_themes();
  $activeTheme = wp_get_theme();
	$result = count($themes);
  $themesInactive = $result - 1;
  $themesInactiveChild = $result - 2;

	if( $result == 0 ) {
    echo '<div class="wps-count-themes wps-border-green">';
    $nbThemesTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous n'avez <strong>aucun thème</strong> installé !</h3>";
    $nbThemesDesc = "<p class=\"nbPluginsDescBloc\">C'est curieux, vous n'avez aucun thème installé actuellement !<br>Est-ce une erreur de votre part ? Votre site ne risque pas de fonctionner ! :)</p>";
    $nbThemesBtn = "<p class=\"nbPluginsBtnBloc\"><a class=\"wps-h-btn-disabled\"><span class=\"dashicons dashicons-yes\"></span> Aucun thème installé actuellement</a></p>";
  }
  elseif ($result == 1){
    echo '<div class="wps-count-themes wps-border-green">';
    $nbThemesTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>un seul thème</strong> installé !</h3>";
    $nbThemesDesc = "<p class=\"nbPluginsDescBloc\">C'est bien, vous n'avez qu'un seul thème installé actuellement !<br>Vous devez savoir qu'il est préférable de ne garder que le thème utilisé ! :)</p>";
    $nbThemesBtn = "<p class=\"nbPluginsBtnBloc\"><a class=\"wps-h-btn-disabled\"><span class=\"dashicons dashicons-yes\"></span> Aucun thème à supprimer</a></p>";
  }
  elseif ($result == 2){
    if($activeTheme->get( 'Template' ) != ""){
      echo '<div class="wps-count-themes wps-border-green">';
      $nbThemesTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>2 thèmes</strong> installés !</h3>";
      $nbThemesDesc = "<p class=\"nbPluginsDescBloc\">C'est bien, vous n'avez que deux thèmes installés actuellement !<br>Et il semble que ce soit <strong>un thème et son thème enfant</strong> ! :)</p>";
      $nbThemesBtn = "<p class=\"nbPluginsBtnBloc\"><a class=\"wps-h-btn-disabled\"><span class=\"dashicons dashicons-yes\"></span> Aucun thème à supprimer</a></p>";
    }
    else {
      echo '<div class="wps-count-themes wps-border-red">';
      $nbThemesTitle = "<h3><span class=\"dashicons dashicons-yes\"></span> Vous avez <strong>2 thèmes</strong> installés !</h3>";
      $nbThemesDesc = "<p class=\"nbPluginsDescBloc\">C'est bien, vous avez deux thèmes installés actuellement !<br>Pensez à <strong>supprimer le thème inutile</strong> ! :)</p>";
      $nbThemesBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/themes.php\" class=\"wps-h-btn-error\"><span class=\"dashicons dashicons-warning\"></span> Supprimer le thème inactif</a></p>";
    }
  }
  else{
    if($activeTheme->get( 'Template' ) != ""){
      echo '<div class="wps-count-themes wps-border-red">';
      $nbThemesTitle = "<h3><span class=\"dashicons dashicons-warning\"></span> Vous avez <strong>$result thèmes</strong> installés !</h3>";
      $nbThemesDesc = "<p class=\"nbPluginsDescBloc\">Vous avez <strong>$result thèmes installés</strong> actuellement dont <strong>un thème enfant et son thème parent</strong> !<br>Pensez à <strong>supprimer les autres thèmes inutilisés</strong> ! :)</p>";
      $nbThemesBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/themes.php\" class=\"wps-h-btn-error\"><span class=\"dashicons dashicons-warning\"></span> Supprimer les thèmes inactifs <span class=\"wps-info\">$themesInactiveChild</span></a></p>";
    }
    else{
      echo '<div class="wps-count-themes wps-border-red">';
      $nbThemesTitle = "<h3><span class=\"dashicons dashicons-warning\"></span> Vous avez <strong>$result thèmes</strong> installés !</h3>";
      $nbThemesDesc = "<p class=\"nbPluginsDescBloc\">Vous avez <strong>$result thèmes installés</strong> actuellement !<br>Pensez à <strong>supprimer les thèmes inutilisés</strong> ! :)</p>";
      $nbThemesBtn = "<p class=\"nbPluginsBtnBloc\"><a href=\"/wp-admin/themes.php\" class=\"wps-h-btn-error\"><span class=\"dashicons dashicons-warning\"></span> Supprimer les thèmes inactifs <span class=\"wps-info\">$themesInactive</span></a></p>";
    }
  }
  echo $nbThemesTitle;
  echo '<div class="nbPluginsContent">';
  echo $nbThemesDesc;
  echo $nbThemesBtn;
  echo '</div>';
  echo '</div>';
}

/* Vérifier l'IP du WordPress pour donner les liens de connexion corrects */
function wpsh_checkIpWps() {
  $urlConsole = "";
  $urlPhpMyAdmin = "";

	$hnServer = gethostname();
  $hostnumber = preg_replace("/[^0-9]/", '', $hnServer);
  if(preg_match('#^wps[0-9][-][a-z]#',$hnServer)){
    echo '<div class="wps-btn-phpmyadmin">';
      echo '<a href="https://allersurmabase-pf' . $hostnumber . '.wpserveur.net" target="blank" class="wps-h-btn"><span class="dashicons dashicons-admin-tools"></span> Aller sur le PhpMyAdmin</a>';
    echo '</div>';
    echo '<div class="wps-btn-console">';
      echo '<a href="https://console.pf' . $hostnumber . '.wpserveur.net" target="blank" class="wps-h-btn"><span class="dashicons dashicons-dashboard"></span> Aller sur la console WPServeur</a>';
    echo '</div>';
  }
  else{
    echo '<div class="wps-btn-phpmyadmin">';
      echo '<a target="blank" class="wps-h-btn"><span class="dashicons dashicons-admin-tools"></span> Aller sur le PhpMyAdmin</a>';
    echo '</div>';
    echo '<div class="wps-btn-console">';
      echo '<a target="blank" class="wps-h-btn"><span class="dashicons dashicons-dashboard"></span> Aller sur la console WPServeur</a>';
    echo '</div>';
    echo '<div class="wps-not-customer">';
      echo 'Vous n\'êtes pas encore client WPServeur !';
    echo '</div>';
  }
}
