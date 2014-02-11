#HISRC MODX Output Modifier
This is a snippet for use with MODX, accepts Image URL's and outputs required tags for use with hisrc.js

##Requirements
This snippet requires the use of [hisrc.js](https://github.com/teleject/hisrc) and [phpthumbof](http://rtfm.modx.com/display/ADDON/phpThumbOf)

You will need to save hisrc.php as a new snippet inside MODX and name it hisrc for these examples to work

##Usage
This snippet can be used as either a basic snippet call, or as an output modifer

###Options
- w = width in pixels **required, represents the width of the 1x image**
- h = height in pixels **required, represents the width of the 1x image**
- img = image url **not required if using as output modifier**
- zc = zoom crop (1 or 0) **default: 0**
- q0 = inital image quality (low res, initial load) **default: 20**
- q1 = 1x image quality loaded via hisrc.js **default: 75**
- q2 = 2x image quality loaded for retina screens **default: 30**
  
###Examples

####Output modifier
```
<img [[*TVImage:hisrc=`w=200,h=50`]] alt="test image" />
```

####Snippet call
```
<img [[!hisrc? &w=`200` &h=`50` &img=`[[*TVImage]]`]] alt="test image"/>
```

##Issues
Feel free to log a bug over at our [github project](https://github.com/DashMedia/MODX-hisrc-output-modifier)