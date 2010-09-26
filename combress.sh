JSDIR="./web/js"
CSSDIR="./web/css"

echo "1. Combining Library Javascript"

# Combine all the javascript to a single temporary file
cat $JSDIR/json2.js \
$JSDIR/jquery.js \
$JSDIR/jquery-ui.js > $JSDIR/tmpJS_library.js

echo "2. Combining Custom Javascript"

# Combine all the javascript to a single temporary file
cat $JSDIR/jquery.scroll.js \
$JSDIR/jquery.metadata.js \
$JSDIR/jquery.qtip.js \
$JSDIR/jquery.qtip.tips.js \
$JSDIR/jquery.qtip.ajax.js \
$JSDIR/swfobject.js \
$JSDIR/jquery.uploadify.js \
$JSDIR/jquery.timer.js \
$JSDIR/jquery.ajaxQueue.js \
$JSDIR/jquery.bgiframe.js \
$JSDIR/jquery.autocomplete.js \
$JSDIR/jquery.livequery.js \
$JSDIR/main.js > $JSDIR/tmpJS_custom.js


echo "3. Combining Library CSS"

# Combine all the CSS to a single temporary file
cat $CSSDIR/jquery-ui-theme.css \
$CSSDIR/jquery.autocomplete.css \
$CSSDIR/uploadify.css \
$CSSDIR/jquery.tips.css > $CSSDIR/tmpCSS_library.css

echo "4. Combining Custom CSS"

# Combine all the CSS to a single temporary file
cat $CSSDIR/main.css > $CSSDIR/tmpCSS_custom.css


echo "5. Compressing JS"
java -jar ./yuicompressor-2.4.2.jar --type js -o $JSDIR/library.js $JSDIR/tmpJS_library.js
java -jar ./yuicompressor-2.4.2.jar --type js -o $JSDIR/combined.js $JSDIR/tmpJS_custom.js

echo "6. Compression CSS"
java -jar ./yuicompressor-2.4.2.jar --type css -o $CSSDIR/library.css $CSSDIR/tmpCSS_library.css
java -jar ./yuicompressor-2.4.2.jar --type css -o $CSSDIR/combined.css $CSSDIR/tmpCSS_custom.css

echo "END, WOOHOO!"