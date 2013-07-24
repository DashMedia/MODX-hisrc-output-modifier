<?php
/**
 * hisrc
 *
 * DESCRIPTION
 *
 * This output modifier accepts an image url and retuns hisrc tags
 *
 * PARAMETERS: w, h, zc, q0 - inital quality, q1 - 1x quality, q2 - 2x quality
 *
 * OUTPUT MODIFIER USAGE:
 * <img [[*TVImageUrl:hisrc=`w=50,h=20,zc=1,q0=20,q1=75,q2=30`]] />
 *
 * w & h are the only REQUIRED variables
 *
 * SNIPPET USAGE:
 *
 * <img [[!hisrc? &img=`[[*TVImage]]` &w=`50` &h=`20` &zc=`0` &q0=`20` &q1=`75` &q2=`30`]] />
 * 
 * img, w and h are the only REQUIRED variables
 * 
 * AUTHOR: Jason Carney, DashMedia.com.au
 */

if(isset($options) && !is_null($options)){
	//options included, execute as output modifier
	$options = explode(",", $options);
	foreach ($options as $key => $value) {
		$line = explode("=", $value);
		$settings[$line[0]] = $line[1];
	}
	if (isset($input) && !is_null($input)) {
		$settings['img'] = $input;
	} 
} else {
	//options not included, execute as snippet call
	$out = "snippet:";
	$settingsArray = array('w', 'h', 'zc', 'q0', 'q1', 'q2', 'img');
	foreach ($settingsArray as $key => $value) {
		if(isset(${$value})){
			$settings[$value] = ${$value};
			$out .= "$value:" . ${$value} . "|";
		}
	}
}

//we now have a setings array populated
$required = array('w', 'h', 'img');
foreach ($required as $key => $value) {
	if(!isset($settings[$value]) || is_null($settings[$value])){
		return "hisrc Error: Missing Required Option: ".$value;
	}
}
//we have all settings required, set defaults for any missing
$defaults = array(
	'zc' => 1, 
	'q0' => 20,
	'q1' => 75,
	'q2' => 30,
	);
$settings = array_merge($defaults, $settings);

//settings array ready with any non-set values set to defaults

for ($i=0; $i < 3; $i++) { 

	if($i == 2){
		//last loop = retina image size
		$settings['w'] *= 2;
		$settings['h'] *= 2;
	}
	$args = 'w='.$settings['w'].'&h='.$settings['h'].'&q='.$settings["q$i"].'&zc='.$settings['zc'];

	$res[$i] = $modx->runSnippet('phpthumbof',array(
	   'input' => $settings['img'],
	   'options' => $args
	));
}

//return formatted hisrc string
$out = 'data-image="hisrc" src="'. $res[0] .'" data-1x="'. $res[1] .'" data-2x="'. $res[2] .'"';
return $out;