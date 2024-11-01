<?php
echo '<div class="wps-tab">';
  echo '<h3>Votre WordPress</h3>';
  echo '<div class="wps-tab-content">';
    echo wpsh_updateWp();
    echo wpsh_updatePlugins();
    echo wpsh_updateThemes();
    echo '<div class="wps-count">';
      echo wpsh_numberPlugins();
      echo wpsh_numberThemes();
    echo '</div>';
  echo '</div>';
echo '</div>';
echo '<div class="wps-tools">';
  echo wpsh_checkIpWps();
echo '</div>';
