<?php
//requi config file
require_once 'config/config.php';

// require redirect

require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

//require_once 'libraries/Core.php';
//require_once 'libraries/Controller.php';

spl_autoload_register(function ($className){
    require_once 'libraries/'.$className.'.php';
});
