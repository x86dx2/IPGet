<?php
// Create array of values
$UserInfo = array(
  'IP' 		      => $_SERVER['REMOTE_ADDR'],
	'Host' 		    => (isset($_SERVER['REMOTE_ADDR']) ? gethostbyaddr($_SERVER['REMOTE_ADDR']) : ""),
	'Port' 		    => $_SERVER['REMOTE_PORT'],
	'User Agent' 	=> $_SERVER['HTTP_USER_AGENT'],
	'Language' 		=> $_SERVER['HTTP_ACCEPT_LANGUAGE'],
	'Mime' 		    => $_SERVER['HTTP_ACCEPT'],
	'Encoding' 	  => $_SERVER['HTTP_ACCEPT_ENCODING'],
	'Charset' 	  => $_SERVER['HTTP_ACCEPT_CHARSET'],
	'Connection'  => $_SERVER['HTTP_CONNECTION'],
	'Cache' 	    => $_SERVER['HTTP_CACHE_CONTROL'],
	'Cookie' 	    => $_SERVER['HTTP_COOKIE'],
	'Referer' 	  => $_SERVER['HTTP_REFERER'],
	'Real_IP' 	  => $_SERVER['HTTP_X_REAL_IP'],
	'FWD_For' 	  => $_SERVER['HTTP_X_FORWARDED_FOR'],
	'FWD_Host' 	  => (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']) : ""),
	'DNT' 		    => $_SERVER['HTTP_DNT']
	);

//Print array in log
$LogDate = new DateTime();
$LogDate = $LogDate->format("y:m:d h:i:s");
$LogUser = fopen('log_ipget.txt', 'a');
fwrite($LogUser, $LogDate);
fwrite($LogUser, print_r($UserInfo, TRUE));
fclose($LogUser);

// Check request (ex. http://x86.rf.gd/ip/?q=ip)
$query=trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($_GET['q'])))))); 

// Return single value on request & die
if (isset($query) && array_key_exists($query, $UserInfo)) {
	empty($UserInfo[$query]) ? die() : die($UserInfo[$query]."\n");
}
// Return full output in TEXT
elseif (isset($query) && ($query=="text")) {
	header('Content-Type: text/plain');
	foreach($UserInfo as $key => $value) {
		echo $key.": ".$value."\n";
	}
	die();
} 
// Return full output in JSON
elseif (isset($query) && ($query=="json")) {
	header('Content-Type: application/json');
	die(json_encode($UserInfo));
}
// Return full output in XML
elseif (isset($query) && ($query=="xml")) {
	header('Content-Type: text/xml');
  function xml_encode(array $arr, SimpleXMLElement $xml) {
    foreach ($arr as $k => $v) {
      is_array($v)
        ? xml_encode($v, $xml->addChild($k))
        : $xml->addChild($k, $v);
    }
    return $xml;
  }
  echo xml_encode($UserInfo, new SimpleXMLElement('<info/>'))->asXML();
  die();
}
// Return full output in HMTL (default)
else {
	header('Content-Type: text/html');
?><!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>What is my IP address? &mdash;</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="What is my IP address?">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/1.0.0/pure-min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/1.0.0/grids-responsive-min.css">
        <style>
          html, .pure-g [class *= "pure-u"] {
            background-color: white;
            font-family: "Open Sans", sans-serif;
          }
          pre {
            font-family: "Monaco", "Menlo", "Consolas", "Courier New", monospace;
            white-space: pre-wrap;       /* Since CSS 2.1 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;
          }
          body {
            margin-left: auto;
            margin-right: auto;
            max-width: 80%;
            margin-bottom: 10px;
          }
          .info_table_value {
            background: #212223;
          }
          .info_table_value:hover, active {
            background: #3d3e3f;
          }
          a {
            background: #e3e3e3;
            text-decoration: none;
            color: #000;
          }
          a:hover, active {
            background: #d7d7d7;
          }
          .ip {
            border: 1px solid #cbcbcb;
            background: #f2f2f2;
            font-size: 36px;
            padding: 6px;
          }
          svg.github-corner {
            fill: #151513;
            color: #fff;
          }
          .footer {
            margin-top: 34px;
            border-top: 1px solid #cbcbcb;
          }
          @media (prefers-color-scheme: dark) {
            html, .pure-g [class *= "pure-u"], a {
              background-color: #161719;
              color:#d8d9da;
              text-decoration: none;
            }
            .ip {
              border: 1px solid #313233;
              background: #212223;
            }
            .footer {
              color: #8e8e8e !important;
              border-top: 1px solid #313233;
            }
            a {
            background: #313233;
            }
            a:hover, active {
            background: #3d3e3f;
            }
            svg.github-corner {
              fill: #f8f9fa;
              color: #161719;
            }
          }
        </style>
      </head>
      <body>
        <div class="pure-g">
          <div class="pure-u-1-1">
            <h1>What is my IP address?</h1>
            <p><code class="ip"><?php echo $UserInfo['IP']; ?></code></p>
            <p>
              Multiple command line HTTP clients are supported, including 
              <a href="https://curl.haxx.se/">curl</a>, 
              <a href="https://github.com/jkbrzt/httpie">httpie</a>, 
              <a href="https://www.gnu.org/software/wget/">GNU Wget</a> and
              <a href="https://www.freebsd.org/cgi/man.cgi?fetch(1)">fetch</a>.
            </p>
          </div>
        </div>
        <div>
          <h2>Your Connection</h2>
          <table id="info_table" summary="info">
            <?php
              foreach($UserInfo as $key => $value) {
                echo '<tr>';
                echo '<td class="info_table_label" style="width: 114px;"><span style="color: #ffffff;">'.$key.': </span></td>';
                echo '<td class="info_table_value" style="width: 114px;"><span style="color: #ffffff;">'.$value.'</td>';
                echo '</tr>';
              }
            ?>          
          </table>
        </div>
        <a href="https://github.com/x86dx2/IPGet" class="github-corner"><svg class="github-corner" width="80" height="80" viewBox="0 0 250 250" style="position: fixed; top: 0; border: 0; right: 0;"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
        <div class="pure-g">
          <div class="pure-u-1-1 footer">
            <p><small>This product available from <a href="https://www.x86.com.br">https://www.x86.com.br</a>.</small></p>
          </div>
        </div>
      </body>
    </html>
<?php
}
die();
?>