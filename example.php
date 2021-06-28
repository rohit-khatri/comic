<pre>
<?php
require_once('xkcd.php');
$xkcd = new xkcd();
$comic = $xkcd->random(); //get the comic #327, Exploits of a Mom.
echo '<h1>'.$comic->safe_title.' - xkcd</h1>'; //prints the title
echo "<img src=\"{$comic->img}\" title=\"{$comic->alt}\"/>"; //prints the image (don't miss the hover text!)
echo '<h2>Transcript</h2><pre>'.$comic->transcript.'</pre>';
echo "<h2>Full version</h2><a href=\"{$comic->url}\">{$comic->url}</a>";