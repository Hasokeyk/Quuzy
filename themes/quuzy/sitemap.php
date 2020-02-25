<?php 
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('memory_limit', '512M');
    
	header('Content-Type: application/xml');
	
	global $mysqli;

	$output  = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<?xml-stylesheet type="text/xsl" href="https://quuzy.com/themes/quuzy/sitemap.xsl"?>'."\n";
	$output  .= '<!-- generated-on="'.date('M d, Y H:i').'" -->'."\n";
	
    $linkler = [];
	$seoLink = $mysqli->query("SELECT fullLink,time FROM seolinks WHERE status = 1 AND template != 'post-detail' ORDER BY id DESC");
    if($seoLink->num_rows > 0){
        while($link = $seoLink->fetch_assoc()){
            $tamLink = SITENAME.$link['fullLink'].'/';
            $linkler[] = [
				'link' => $tamLink,
				'time' => $link['time'],
			];
        }
    }
    
    $sayfala = 1000;
	$toplam = ceil(count($linkler)/$sayfala);
	$bugun = time();
    
    $url = $_SERVER['REQUEST_URI'];
	preg_match('|sitemap-(.*?).xml|is',$url,$sonuc);
    
    if(isset($sonuc[1]) and is_numeric($sonuc[1]) and !empty($sonuc[1]) and $sonuc[1]<=$toplam){
		
		$output .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
		$basla = ($sonuc[1]-1)*$sayfala;
		$say = 0;
		$eklenen = 0;
		foreach ($linkler as $l){
			
			if($say >= $basla and $say <= ($basla+$sayfala)){
				$output .= "\t".'<url>'."\n";
				$output .= "\t\t".'<loc>'.$l['link'].'</loc>'."\n";
				$output .= "\t\t".'<lastmod>'.date('Y-m-d',$l['time']).'T'.date('H:m:s+00:00',$l['time']).'</lastmod>'."\n";
				$output .= "\t\t".'<changefreq>weekly</changefreq>'."\n";
				$output .= "\t\t".'<priority>0.8</priority>'."\n";
				$output .= "\t".'</url>'."\n";
				$eklenen++;
			}
			
			if($eklenen==$sayfala){
				break;
			}
			
			$say++;
			
		}
		$output .= '</urlset>'."\n";
		
	}else{
		
		$output .= '<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
		for($i=1; $i<($toplam+1); $i++){
			$output .= "\t".'<sitemap>'."\n";
			$output .= "\t\t".'<loc>https://quuzy.com/sitemap-'.$i.'.xml</loc>'."\n";
			$output .= "\t\t".'<lastmod>2018-07-28T11:02:21+00:00</lastmod>'."\n";
			$output .= "\t".'</sitemap>'."\n";
		}
		$output .= '</sitemapindex>'."\n";
	}
	
	$name = isset($sonuc[1])?'sitemap-'.$sonuc[1].'.xml':'sitemap.xml';
	if(file_exists(ROOT.'/cache/sitemap/'.$name)){
		echo file_get_contents(ROOT.'/cache/sitemap/'.$name);
	}else{
		$ac = fopen(ROOT.'/cache/sitemap/'.$name,'w');
		fwrite($ac,$output);
		fclose($ac);
		echo $output;
	}
	