<?php
error_reporting(E_ALL ^ E_NOTICE);
$prefix_url = 'https://cameronarchaeology.com/';  //--> แก้ Main URL
$files = glob("get-youtube-id/*.txt");
//print_r($files);
$xml_video_sitemap = '';
$xml = '';
$xml_image = '';
$xml_image_sitemap = '';
$get_youtube0_txt=file("$files[0]");
$get_youtube1_txt=file("$files[1]");
$xmlcfg_csv=file("data_amz.csv");
//print_r($get_youtube0_txt);
array_merge($get_youtube1_txt, $get_youtube0_txt);
$get_youtube01 = explode('###',$get_youtube0_txt[0]);
$get_youtube02 = explode('###',$get_youtube1_txt[0]);
$mix_get_youtube = array_merge($get_youtube01, $get_youtube02);

unset($mix_get_youtube[101]);
unset($mix_get_youtube[50]);
$num_line = count($mix_get_youtube);
//print_r($mix_get_youtube);
for ($a=0;$a<$num_line;$a++) {
$mix_get_youtube_array = explode(':|:',$mix_get_youtube[$a]);
$mix_get_yt_id[$a] = $mix_get_youtube_array[0];
$mix_get_yt_title[$a] = $mix_get_youtube_array[1];
$title1 = trim(ucwords(strtolower($xmlcfg_csv[$a])));
$title2 = strtolower($title1);
$linkimages = trim($prefix_url).'images/'.trim(str_replace(' ','-',$title2)).'.jpg';
$linksubfolder = $prefix_url.trim(str_replace(' ','-',$title2)).'/';
$date_create_sitemap = date('c',time());

		$xml .= "\n <url>\n";
        $xml .= " <loc>$linksubfolder</loc>\n";
        $xml .= " <video:video>\n";
        $xml .= "  <video:player_loc allow_embed=\"yes\" autoplay=\"autoplay=1\">https://www.youtube.com/watch?v=$mix_get_yt_id[$a]</video:player_loc>\n";
        $xml .= "  <video:thumbnail_loc>".$linkimages ."</video:thumbnail_loc>\n";
        $xml .= "  <video:title>" .$title1 . "</video:title>\n";
        $xml .= "  <video:description>" . $title1 ." ". $mix_get_yt_title[$a] . "</video:description>\n";
 		$xml .= "  <video:publication_date>".$date_create_sitemap."</video:publication_date>\n";
        $xml .= " </video:video>\n </url>";
		
		$xml_image .= "\n <url>\n";
        $xml_image .= " <loc>$linksubfolder</loc>\n";
        $xml_image .= " <image:image>\n";
        $xml_image .= "  <image:loc>".$linkimages ."</image:loc>\n";
		$xml_image .= "  <image:title>".$title1."</image:title>"."\n";
		$xml_image .= "  <image:caption>".$title1 ." ". $mix_get_yt_title[$a]."</image:caption>"."\n";
        $xml_image .= "  </image:image>\n";
        $xml_image .= " </url>\n";
}

		$xml_image .= "\n</urlset>";
		
		$xml_image_sitemap  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";       
        $xml_image_sitemap .= '<!-- Created by (http://wordpress.org/extend/plugins/xml-sitemaps-for-videos/) -->' . "\n";
        $xml_image_sitemap .= '<!-- Generated-on="' . date("F j, Y, g:i a") .'" -->' . "\n";             
        $xml_image_sitemap .= '<?xml-stylesheet type="text/xsl" href="youtube/image-sitemap.xsl"?>' . "\n" ;        
        $xml_image_sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
		
		$xml .= "\n</urlset>";
		
		
		$xml_video_sitemap  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";       
        $xml_video_sitemap .= '<!-- Created by (http://wordpress.org/extend/plugins/xml-sitemaps-for-videos/) -->' . "\n";
        $xml_video_sitemap .= '<!-- Generated-on="' . date("F j, Y, g:i a") .'" -->' . "\n";             
        $xml_video_sitemap .= '<?xml-stylesheet type="text/xsl" href="youtube/video-sitemap.xsl"?>' . "\n" ;        
        $xml_video_sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">' . "\n";
		
		$final_video_sitemap = $xml_video_sitemap.$xml;
		$final_image_sitemap = $xml_image_sitemap.$xml_image;
		//echo $final_video_sitemap;
		file_put_contents('video-sitemap.xml',$final_video_sitemap);
		file_put_contents('image-sitemap.xml',$final_image_sitemap);
?>
