<? include"main-dbcon.php"; ?>
<?php

    if (!function_exists('http_response_code')) {
        function http_response_code($code = NULL) {

            if ($code !== NULL) {

                switch ($code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
                }

                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                header($protocol . ' ' . $code . ' ' . $text);

                $GLOBALS['http_response_code'] = $code;

            } else {

                $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

            }

            return $code;

        }
    }

?>

<?
$content=$general->getAll("content_cms where id_cms=18");
$meta = $general->get_metathings("content_cms",$content[0]['id_cms']); ?>
<?php http_response_code(404);?>
<? include"inc_head.php";?>

<body>
<div class="se-pre-con"></div>
<? include"inc_header.php";?><!--END OF HEADER--->
<link rel="stylesheet" type="text/css" href="<?=$conf->site_url?>css/404.css">

<div class="banner">
				<div id="carousel" class="carousel slide h-100 carousel-fade" data-ride="carousel">
				  <div class="carousel-inner h-100">
					<div class="carousel-item active h-100">
					  <!--<img class="d-block w-100 img-fluid h-100" src="images/banner1.jpg" alt="">-->
                      <img src="<? if($content[0]['image_name_cms']!="" && file_exists($conf->absolute_path.$conf->general_dir.$content[0]['image_name_cms'])){echo $conf->site_url.$conf->general_dir.$content[0]['image_name_cms'];}else{ echo $conf->site_url."images/about.jpg"; }?>" alt="<?=$content[0]['image_alt_cms']?>" title="<?=$content[0]['image_title_cms']?>" class="d-block w-100 img-fluid h-100">
					</div><!--END OF CAROUSEL ITEM-->
					<!--END OF CAROUSEL ITEM-->
				  </div><!--END OF CAROUSEL INNER-->
				</div><!--END OF CAROUSEL-->
</div><!--END OF BANNER-->

<div class="content">
<div class="container">
	<div class="col-md-8 offset-md-4 bg_white">
		<div class="breds">
		<!--<ul class="list-unstyled">
			<li><a href="#">Home</a></li>
			<li>About Us</li>
		</ul>-->
        <ul class="list-unstyled">
			<li><a href="<?=$conf->site_url?>"><?=$nav[0]['name_cms']?></a></li>
			<li><?=$content[0]['name_cms']?></li>
		</ul>
		
		<h3><?=$content[0]['name_cms']?></h3>
</div><!--END OF BREDS-->

<div class="about">
<div class="not_found">
        
        	<h3>the page you're looking for <span>can't be found</span></h3>
            
            <div class="not_found_form">
            <form method="post" id="frm" action="<?=$conf->site_url.$general->smartURLnew2("content_cms",19)?>">
            	<input type="submit" class="btn"  />
                <input type="text" name="searchTxt" class="form-control" placeholder="Search Architectural Corner" required />
            </form>
            </div><!--END OF NOT FOUND FORM-->
            <div class="clearfix"></div>
        <h3>or <a href="<?=$conf->site_url.$general->smartURLnew2("content_cms",20)?>">see our site map</a></h3>
        </div>
<!--<p>Architectural Corner operates in Dubai since 1976 as an architectural and engineering consultancy. Ithas been involved as the architectural and engineering consultant in the growth of Dubai, particularly the Jebel Ali Free Zone, and other industrial zones in Dubai.</p>

<p>Under present management since 2008, Architectural Corner has expanded the scope of the design work in the UAE and abroad, and has worked on various industrial, commercial and residential projects as the lead or design consultant.</p>

<h4>Organization</h4>

<p>Having been established in UAE since 1976, involved in various kinds of projects ranging from residential and commercial to logistic and industrial buildings. With our experienced and committed staff, we offer complete architectural solutions including execution supervision.</p>

<h4>Design Philosophy</h4>
<p>We provide end-to-end professional services, which encapsulate our commitment vision with our tailormade solutions. Our infrastructure & support systems have been developed over a period of time to provide functional, economical and special accent on quality, time and aesthetics.</p>-->

</div><!--END OF CONTACT-->

</div><!--END OF COL MD 11--->
</div><!--END OF CONTAINER--->


</div><!--END OF CONTENT-->




<? include"inc_footer.php";?><!--END OF FOOTER-->

<? include"inc_script.php";?>