<?php
  //Variables
  $IpUser = $_SERVER['REMOTE_ADDR'];
  $Hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  $PortUser = $_SERVER['REMOTE_PORT'];
  $UserAgent = $_SERVER['HTTP_USER_AGENT'];
  $Protocol = $_SERVER['SERVER_PROTOCOL'];
  $HttpRef = $_SERVER['HTTP_REFERER'];

  
  //Print IP, Hostname, Port Number, User Agent and Referer To Log.TXT
  $fh = fopen('ipget.log.txt', 'a');
  fwrite($fh, 'IP Address: '."".$IpUser ."\n");
  fwrite($fh, 'Hostname: '."".$Hostname ."\n");
  fwrite($fh, 'Port Number: '."".$PortUser ."\n");
  fwrite($fh, 'User Agent: '."".$UserAgent ."\n");
  fwrite($fh, 'Protocol: '."".$Protocol ."\n");
  fwrite($fh, 'HTTP Referer: '."".$HttpRef ."\n\n");
  fclose($fh);

  if ( stristr( strtolower( $_SERVER['HTTP_USER_AGENT'] ), "mozilla" ) ) { /* Serve html for graphical interfaces */
?>
    <!DOCTYPE html>
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
            <p><code class="ip"><?php print $IpUser; ?></code></p>
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
            <tr>
              <td class="info_table_label" style="width: 114px;"><span style="color: #ffffff;">Hostname:</span></td>
              <td><?php print $Hostname;?></td>
            </tr>
            <tr>
              <td class="info_table_label" style="width: 114px;"><span style="color: #ffffff;">Port:</span></td>
              <td><?php print $PortUser;?></td>
            </tr>
            <tr>
              <td class="info_table_label" style="width: 114px;"><span style="color: #ffffff;">User Agent:</span></td>
              <td><?php print $UserAgent;?></td>
            </tr>
            <tr>
              <td class="info_table_label" style="width: 114px;"><span style="color: #ffffff;">Protocol:</span></td>
              <td><?php print $Protocol;?></td>
            </tr>
            <tr>
              <td class="info_table_label" style="width: 114px;"><span style="color: #ffffff;">HTTP Ref.:</span></td>
              <td><?php print $HttpRef;?></td>
            </tr>
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
  } else {
    print $_SERVER['REMOTE_ADDR'] . PHP_EOL; /* Serve ip-only for text-browsers */
  }
?>