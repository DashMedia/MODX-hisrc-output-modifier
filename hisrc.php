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
 * w or h are the only REQUIRED variables
 *
 * SNIPPET USAGE:
 *
 * <img [[!hisrc? &img=`[[*TVImage]]` &w=`50` &h=`20` &zc=`0` &q0=`20` &q1=`75` &q2=`30`]] />
 * 
 * img, (w or h) are the only REQUIRED variables
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
$settingsArray = array('w', 'h', 'zc', 'q0', 'q1', 'q2', 'img','far','iar','bg','aoe', 'wp', 'hp', 'wl', 'hl', 'ws', 'hs', 'f', 'sx', 'sy', 'sw', 'sh', 'bc', 'fltr', 'md5s', 'xto', 'ra', 'ar', 'sfn', 'dpi', 'sia', 'maxb', 'down');
foreach ($settingsArray as $key => $value) {
if(isset(${$value})){
$settings[$value] = ${$value};
$out .= "$value:" . ${$value} . "|";
}
}
}

//remove any 'blank' settings
foreach ($settings as $key => $value) {
if(is_null($value) || $value == ''){
unset($settings[$key]);
}
}

//we now have a setings array populated
if(!isset($settings['img']) || is_null($settings['img'])){
return "hisrc Error: Missing Required Option: img";
}
//we have all settings required, set defaults for any missing
$defaults = array( 
'q0' => 20,
'q1' => 75,
'q2' => 30,
'h'  => NULL,
'w'  => NULL
);
$settings = array_merge($defaults, $settings);

if(is_null($settings['h']) && is_null($settings['w'])){
return "hisrc Error: Must provide at least one dimension";
}
//create configs list of settings which don't change between sizes
$ignore = array('w', 'h', 'q0', 'q1', 'q2', 'img');
$configs="";
foreach ($settings as $key => $value) {
if(!in_array($key,$ignore)){
$config .= "&".$key."=".$value;
}
}

$options = "";
//Q0 size
if(!is_null($settings['w'])){
$options .= '&w='.($settings['w'] / 2);
}
if(!is_null($settings['h'])){
$options .= '&h='.($settings['h'] / 2);
}
$res[0] = $modx->runSnippet('phpthumbof',array(
  'input' => $settings['img'],
  'options' => $options.'&q='.$settings["q0"].$config
));
//Q1 Size
$options = "";
if(!is_null($settings['w'])){
$options .= '&w='.$settings['w'];
}
if(!is_null($settings['h'])){
$options .= '&h='.$settings['h'];
}
$res[1] = $modx->runSnippet('phpthumbof',array(
  'input' => $settings['img'],
  'options' => $options.'&q='.$settings["q1"].$config
));
//Q2 Size
$options ="";
if(!is_null($settings['w'])){
$options .= '&w='.($settings['w'] * 2);
}
if(!is_null($settings['h'])){
$options .= '&h='.($settings['h'] * 2);
}
$res[2] = $modx->runSnippet('phpthumbof',array(
  'input' => $settings['img'],
  'options' => $options.'&q='.$settings["q2"].$config
));
$options = "";
if(!is_null($settings['w'])){
$options .= ' width="'.$settings['w'].'"';
}
if(!is_null($settings['h'])){
$options .= ' height="'.$settings['h'].'"';
}
$settings['w'] /= 2;
$settings['h'] /= 2;
//return formatted hisrc string
$out = 'data-image="hisrc" src="'. $res[0] .'" data-1x="'. $res[1] .'" data-2x="'. $res[2] . '"' . $options;
return $out;