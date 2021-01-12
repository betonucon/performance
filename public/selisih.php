<?php
	$tgl1 = new DateTime("2021-01-11");
	$tgl2 = new DateTime("2021-01-10");
	$d = $tgl2->diff($tgl1)->days + 1;
	echo $d." hari";
?>