<?php

$parallel = new parallel\Runtime();

$parallel->run(function(){
    echo "OK";
});
die;
