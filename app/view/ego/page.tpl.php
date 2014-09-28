<?php
	echo "
<article class='article-page'>
	<h1>".$title."</h1>".(isset($content) ? $content : "")."
</article>";
?>