<?php 

function hari_ini()
{
    $dayNames = array(
        0=>'Min',
        1=>'Sen', 
        2=>'Sel', 
        3=>'Rab', 
        4=>'Kam', 
        5=>'Jum', 
        6=>'Sab', 
    );
    
    $tgl = date("d M Y");
    $hari_ini = $dayNames[date("w")] . ", $tgl";
    return $hari_ini;
    
}

?>