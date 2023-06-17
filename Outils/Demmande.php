<?php 
require_once("../Model/Covoit.php");
function enAttente($covoits) {
    $res = [];
        foreach ($covoits as $covoit) {
            if ($covoit->getAccepter()==0) {
                $res[] = $covoit;
            }
        }
    
    return $res;
}
function accepter($covoits) {
    $res = [];
    
    if (is_array($covoits)) {
        foreach ($covoits as $covoit) {
            if ($covoit->getAccepter()==1) {
                $res[] = $covoit;
            }
        }
    }
    
    return $res;
}

?>