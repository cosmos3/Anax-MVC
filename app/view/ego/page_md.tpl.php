<?php
	echo "
<article class='article-md'>".(isset($content) ? $content : "").(isset($byline) ? "<footer class='byline-md'>".$byline."</footer>" : "")."
</article>";
?>