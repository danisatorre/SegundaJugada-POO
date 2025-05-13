<?php

    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';

    include($path . "/utils/common.inc.php");
    include($path . "/utils/mail.inc.php");
    include($path . "/paths.php");   

    include($path . "/module/home/model/BLL/home_bll.class.singleton.php");
    include($path . "/module/home/model/DAO/home_dao.class.singleton.php");

    include($path . "/module/shop/model/BLL/shop_bll.class.singleton.php");
    include($path . "/module/shop/model/DAO/shop_dao.class.singleton.php");

    include($path . "/module/search/model/BLL/search_bll.class.singleton.php");
    include($path . "/module/search/model/DAO/search_dao.class.singleton.php");

    include($path . "/model/db.class.singleton.php");
    include($path . "/model/Conf.class.singleton.php");

    include($path . "/model/jwt.class.php");
    include($path . "/model/middleware_auth.php");

?>