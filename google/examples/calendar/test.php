<?php

$ext = get_loaded_extensions();
foreach ($ext as &$value) {
    print "<br>".$value;
}


phpinfo();
