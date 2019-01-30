<?php 
    # Load Config
    require_once 'config/config.php';

    # Load Helpers
    require_once 'helpers/url_helper.php';

    # Load Libraries
    // require_once  'libraries/controller.php';
    // require_once  'libraries/core.php';
    // require_once  'libraries/database.php';


    # Autoload Core Libraries
    spl_autoload_register(function($className) {

        require_once 'libraries/' . $className . '.php';


    });

?>