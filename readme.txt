hisrc
DESCRIPTION
This output modifier accepts an image url and retuns hisrc tags

REQUIREMENTS
-phpthumbof or another package usign the same name-space
-hisrc.js https://github.com/teleject/hisrc
	JS INIT
	//normal hisrc images
	$("img[data-image='hisrc']").hisrc({
	   minKbpsForHighBandwidth:'200'//,
	   // forcedBandwidth:'high' 
	 });
	 //bg hisrc images
	$("img[data-image='hisrc-bg']").hisrc({
	 useTransparentGif: true,
	 transparentGifSrc: '/assets/static/img/blank.gif',
	   minKbpsForHighBandwidth:'200'//,
	   // forcedBandwidth:'high'
	 });

PARAMETERS: w, h, zc, q0 - inital quality, q1 - 1x quality, q2 - 2x quality
(any parameter that isn't known to hisrc is passed directly into phpthumbof)

OUTPUT MODIFIER USAGE:
<img [[*TVImageUrl:hisrc=`w=50,zc=1,q0=20,q1=75,q2=30,bg=1`]] />
w or h are the only REQUIRED variables

SNIPPET USAGE:
<img [[!hisrc? &img=`[[*TVImage]]` &w=`50` &h=`20` &zc=`0` &q0=`20` &q1=`75` &q2=`30`]] />
img, (w or h) are the only REQUIRED variables

q# refers to the phpthumb quality level of the corispnding version of the image 
	0-Inital fuzzy image
	1-Normal image
	2-Retina image
	
AUTHOR: Jason Carney, DashMedia.com.au