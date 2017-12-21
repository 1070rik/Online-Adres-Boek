<?php
	//Als hexadecimaal voeg %23 toe voor de kleurcode.
	if(empty($_GET['color'])) {
		$color = "red";
	} else {
		$color = htmlspecialchars_decode($_GET['color']);
	}
	
	if(empty($_GET['dot']) || $_GET['dot'] == "true") {
		$dot = true;
	} else {
		$dot = false;
	}
	
	header('Content-Type: image/svg+xml');
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>
<svg width="22" height="34" version="1.1" viewBox="0 0 5.5562 8.9958" xmlns="http://www.w3.org/2000/svg">
 <g>
  <path d="m2.6782 0.26665a2.5135 2.5135 0 0 0-1.4009 0.49506 2.5135 2.5135 0 0 0-0.86093 2.8763l2.3621 5.0777 2.3621-5.0777a2.5135 2.5135 0 0 0-0.86093-2.8763 2.5135 2.5135 0 0 0-1.6015-0.49506z" stroke-width=".23896"/>
  <path d="m2.6877 0.51357a2.2622 2.2622 0 0 0-1.2609 0.44555 2.2622 2.2622 0 0 0-0.77484 2.5887l2.1259 4.57 2.1259-4.57a2.2622 2.2622 0 0 0-0.77484-2.5887 2.2622 2.2622 0 0 0-1.4413-0.44555z" fill="<?php echo $color; ?>" stroke-width=".21506"/>
  <?php if($dot) { echo '<ellipse cx="2.7779" cy="2.8501" rx=".66146" ry=".66146" fill="#000100" stroke-width="0" style="paint-order:normal"/>'; } ?>
 </g>
</svg>