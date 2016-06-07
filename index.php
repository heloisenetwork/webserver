<?php
// exception to forward if the base site
$base_site = "http://heloise.ish-lyon.cnrs.fr"; 
if (strpos($_SERVER['REQUEST_URI'], '/forum') === 0) { header("Location: ".$base_site.$_SERVER['REQUEST_URI']); exit; }
if (strpos($_SERVER['REQUEST_URI'], '/partners') === 0) { header("Location: http://".$_SERVER['HTTP_HOST']."/repositories"); exit; }

// get content from external website
$context = stream_context_create(array("http" => array("method"=>"GET", "header" => "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:46.0) Gecko/20100101 Firefox/46.0\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8")));
$html = file_get_contents($base_site.$_SERVER['REQUEST_URI'], false, $context);

// filter id=content element
$dom = new DOMDocument;
$dom->loadHTML($html);
$content = $dom->getElementById('content');
libxml_use_internal_errors(false);

// use this for ajax calls in future 
if ((!empty($_GET['ajax']))) {
	echo $dom->saveHTML($content);
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Héloïse - European Network on Digital Academic History </title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/kube.min.css" />
    <link rel="stylesheet" href="css/navigation.css" />
    <link rel="stylesheet" href="heloise.css" />
    <link href='https://fonts.googleapis.com/css?family=Average+Sans' rel='stylesheet' type='text/css'>

</head>
<body>

<?php // The header ?>
    <row id="header" centered>
        <column cols="10" class="title text-centered">Heloise - European Network on Digital Academic History</column>
    </row>
    <row centered>
        <column cols="10"><img id="title" src="http://f.hypotheses.org/wp-content/blogs.dir/819/files/2012/09/cropped-cropped-scena-di-scuola.jpg"/>
	</column>
    </row>


<?php // The menu ?>
    <row centered>
        <column cols="10">
		<ul class="topnav">
		  <li><a <?php if ($_SERVER['REQUEST_URI']=="/") echo 'class="active" ';?>href="/">Home</a></li>
		  <li><a <?php if ($_SERVER['REQUEST_URI']=="repositories") echo 'class="active" ';?>href="repositories">Repositories</a></li>
		  <li><a <?php if ($_SERVER['REQUEST_URI']=="heloise_advisory_committee") echo 'class="active" ';?>href="heloise_advisory_committee">Advisory Committee</a></li>
		  <li><a <?php if ($_SERVER['REQUEST_URI']=="platform") echo 'class="active" ';?>href="platform">Platform</a></li>
		  <li class="icon">
		    <a href="javascript:void(0);" style="font-size:15px;" onclick="showNavButton()">☰</a>
		  </li>
		</ul>

		<script>
		function showNavButton() {
		    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
		}
		</script>
	</column>
    </row>



<?php // The content ?>
    <row id="page" centered>
        <column cols="10">

	<?php echo $dom->saveHTML($content);?>
	</column>
    </row>

<?php // The footer ?>
    <row id="footer" centered>
        <column cols="10">

	About Heloise Network:  <a href="heloise_advisory_committee">Advisory Committee</a>, <?php echo date("F Y");  ?>
	<p id="login"><a href="<?php echo $base_site.$_SERVER['REQUEST_URI']; ?>">Member access</a></p>

	</column>


    </row>

</body>
</html>
