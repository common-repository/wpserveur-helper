<?php
echo '<div class="wps-main">';
echo '<div class="wps-logo"><a href="https://www.wpserveur.net/?refwps=206" target="blank"><img src="' . plugins_url( '/assets/img/wps-logo.png', dirname(__FILE__) ) . '"></a></div>';
echo '<p>Cher client WPServeur, bienvenue dans l\'outil d\'aide WPServeur intégré à votre WordPress !</p>';
echo '<p>Ici vous pouvez retrouver des liens qui pourront vous être utiles pour la gestion de votre WordPress chez WPServeur ainsi que des outils pour vous aider à garder
votre site WordPress sécurisé et performant !</p>';
echo wpsh_check_temporary_url();
