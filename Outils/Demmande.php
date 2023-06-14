<?php 
require_once("../Model/Covoit.php");
function enAttente($covoits) {
    $res = [];
        foreach ($covoits as $covoit) {
            $accepter = filter_var($covoit->getAccepter(), FILTER_VALIDATE_BOOLEAN);
            if (!$accepter) {
                $res[] = $covoit;
            }
        }
    
    return $res;
}
function accepter($covoits) {
    $res = [];
    
    if (is_array($covoits)) {
        foreach ($covoits as $covoit) {
            if ($covoit->getAccepter()) {
                $res[] = $covoit;
            }
        }
    }
    
    return $res;
}

?>