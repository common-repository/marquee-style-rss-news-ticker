<?php

/*
Plugin Name: Marquee Style RSS News Ticker
Description: Creative Software Design Solutions Marquee Style RSS News Ticker is a simple WordPress plugin to create a marquee for 
			 your WordPress website with up to 5 rss feeds, a take off from Gopi R Marquee xml rss feed scroll , however this one 
			 works and I have added some extra features with more in store!
Author: 	 Brian Novotny - Creative Software Design Solutions
Version: 	 3.2.0
Plugin URI:  http://creative-software-design-solutions.com/creative-software-design-solutions-marquee-news-ticker-wordpress-plugin/
Author URI:  http://creative-software-design-solutions.com/
Donate link: http://creative-software-design-solutions.com/
*/

/**
 *     Marquee Style RSS News Ticker
 *     Copyright (C) 2012  Creative Software Design Solutions
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */	


function rssshow(){
	global $wpdb;
	$options = get_option('csds_marquee');
	if( empty( $options ) ){
		csds_marquee_update_options();
	}
	$displaycount;
	$feedcount = 0;
	$feeds = array();
	$titles = array();
	$mxrf_marquee = "";
	$csds_scrollamount = $options['csds_scrollamount'];
	$csds_scrolldelay = $options['csds_scrolldelay'];
	$csds_direction = $options['csds_direction'];
	$csds_news_items = $options['csds_news_items'];
	$csds_style = $options['csds_style'];
	
	$csds_rss1_title = $options['csds_rss1_title'];
	$csds_rss2_title = $options['csds_rss2_title'];
	$csds_rss3_title = $options['csds_rss3_title'];
	$csds_rss4_title = $options['csds_rss4_title'];
	$csds_rss5_title = $options['csds_rss5_title'];
	
	$csds_rss1_url = $options['csds_rss1_url'];
	$csds_rss2_url = $options['csds_rss2_url'];
	$csds_rss3_url = $options['csds_rss3_url'];
	$csds_rss4_url = $options['csds_rss4_url'];
	$csds_rss5_url = $options['csds_rss5_url'];
	$csds_spliter = $options['csds_spliter'];
	$csds_target = $options['csds_target'];
	$csds_support = $options['csds_support'];
	
	if(!is_numeric($csds_scrollamount)){
		$csds_scrollamount = 2;
	} 
	if(!is_numeric($csds_scrolldelay)){
		$csds_scrolldelay = 5;
	} 
	if(!is_numeric($csds_news_items)){
		$csds_news_items = 10;
	}
	
	if($csds_rss1_url  <> ""){
		$feedcount += 1;
		$titles[] = $csds_rss1_title;
		$feeds[] =  $csds_rss1_url;
	}
	if($csds_rss2_url  <> ""){
		$feedcount += 1;
		$titles[] = $csds_rss2_title;
		$feeds[] =  $csds_rss2_url;
	}
	if($csds_rss3_url  <> ""){
		$feedcount += 1;
		$titles[] = $csds_rss3_title;
		$feeds[] =  $csds_rss3_url;
	}
	if($csds_rss4_url  <> ""){
		$feedcount += 1;
		$titles[] = $csds_rss4_title;
		$feeds[] =  $csds_rss4_url;	
	}
	if($csds_rss5_url  <> ""){
		$feedcount += 1;
		$titles[] = $csds_rss5_title;
		$feeds[] =  $csds_rss5_url;
	}
	
	csds_show_feed( $feeds, $titles );
	
}

add_filter('the_content','csds_show_filter');

function csds_show_filter( $content ){
	return 	preg_replace_callback( '/\[RSS-MARQUEE=(.*?)\]/sim','csds_show_filter_callback', $content );
}

function  csds_cdata( $data ){
	$data = str_replace('<![CDATA[', '', $data);
	$data = str_replace(']]>', '', $data);
	if ( substr($data, -1) == ']' ){
		$data .= ' ';
	}
	if ( substr($data, -1) == '\'' ){
		$data .= '&#39';
	}
	return $data;
}


function csds_show_filter_callback( $matches ){
	global $wpdb;
	$options = get_option('csds_marquee');
	if( empty( $options ) ){
		csds_marquee_update_options();
	}
	$display_link = 'http://creative-software-design-solutions.com';
	$display_name = 'Powered By Creative Software Design Solutions';	
	$type =  $matches[1];
	$csds = (string) '';
	$feedstitle1 = "";
	$csds_marquee = "";
	$count = 0;
	$csds_scrollamount = $options['csds_scrollamount'];
	$csds_scrolldelay = $options['csds_scrolldelay'];
	$csds_direction = $options['csds_direction'];
	$csds_news_items = $options['csds_news_items'];
	$csds_style = $options['csds_style'];
	$csds_rss1_url = $options['csds_rss1_url'];
	$csds_rss2_url = $options['csds_rss2_url'];
	$csds_rss3_url = $options['csds_rss3_url'];
	$csds_rss4_url = $options['csds_rss4_url'];
	$csds_rss5_url = $options['csds_rss5_url'];
	$csds_spliter = $options['csds_spliter'];
	$csds_target = $options['csds_target'];
	$csds_support = $options['csds_support'];
	
	if( !is_numeric($csds_scrollamount)){
		$csds_scrollamount = 2;
	} 
	if(!is_numeric($csds_scrolldelay)){
		$csds_scrolldelay = 5;
	} 
	
	if( $type == "RSS1" ){
		$url = $options['csds_rss1_url'];
		$feedstitle1 = $options['csds_rss1_title'];
	}elseif( $type == "RSS2" ){
		$url = $options['csds_rss2_url'];
		$feedstitle1 = $options['csds_rss2_title'];
	}elseif( $type == "RSS3" ){
		$url = $options['csds_rss3_url'];
		$feedstitle1 = $options['csds_rss3_title'];
	}elseif($type == "RSS4"){
		$url = $options['csds_rss4_url'];
		$feedstitle1 = $options['csds_rss4_title'];
	}elseif($type == "RSS5"){
		$url = $options['csds_rss5_url'];
		$feedstitle1 = $options['csds_rss5_title'];
	}else{
		$url = "http://wordpress.org/news/feed/";
	}
	
	$nodata = ' No data from this feed available at this time, check feed url or website feed please! -//- ';
	$cnt= 0;
	$spliter = $csds_spliter;
	$doc = new DOMDocument();
	$doc->load( $url );
	$items = $doc->getElementsByTagName( "item" );
	$itemsListLength = $items->length;
	if ( $itemsListLength > 0 ){
		if(@$csds_support == "1"){
		$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$display_link."'>" . $display_name . "</a>" .$spliter;
		}
		
		$csds = $csds . $feedstitle1 . ' ';
		foreach( $items as $item ){
			$paths = $item->getElementsByTagName( "title" );
			$title = mysql_real_escape_string(csds_cdata($paths->item(0)->nodeValue));
			$title = stripslashes($title);
			$paths = $item->getElementsByTagName( "link" );
			$links = mysql_real_escape_string(csds_cdata($paths->item(0)->nodeValue));
			$links = stripslashes($links);
			if($count >= 0){
				$spliter = $csds_spliter;
			}
			$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$links."'>" . $title . "</a>";
			$count = $count + 1;
			if($count == $csds_news_items){
				$count = 0;
				break;
			}
		}
	}elseif( $itemsListLength == 0 && $csds_support == "1" ){
		$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$display_link."'>" . $display_name . "</a>" . $spliter;
		$csds = $csds . $feedstitle1 . $spliter . $nodata;	
	}elseif($itemsListLength == 0 && $csds_support == "2"){
		$csds = $csds . $spliter . $feedstitle1 . $spliter . $nodata;	
	}
	$csds_marquee = $csds_marquee . "<div style='padding:3px;' class='csds_marquee'>";
	$csds_marquee = $csds_marquee . "<marquee style='$csds_style' scrollamount='$csds_scrollamount' scrolldelay='$csds_scrolldelay' direction='$csds_direction' onmouseover='this.stop()' onmouseout='this.start()'>";
	$csds_marquee = $csds_marquee . $csds;
	$csds_marquee = $csds_marquee . "</marquee>";
	$csds_marquee = $csds_marquee . "</div>";
	return $csds_marquee;
	
}

function csds_show_feed( $feeds, $feedtitles ){
	
	global $wpdb;
	$options = get_option('csds_marquee');
	if( empty( $options ) ){
		csds_marquee_update_options();
	}
	$csds = (string) '';
	$count = (int) 0;
	$feedname = "";
	$display_link = 'http://creative-software-design-solutions.com';
	$display_name = 'Powered By Creative Software Design Solutions';
	$i = (int) 0;
	$feedsran = (int) 0;
	$displaycount;
	$csds_marquee = "";
	$feedtitle = array();
	$csds_scrollamount = $options['csds_scrollamount'];
	$csds_scrolldelay = $options['csds_scrolldelay'];
	$csds_direction = $options['csds_direction'];
	$csds_news_items = $options['csds_news_items'];
	$csds_style = $options['csds_style'];	
	$csds_rss1_title = $options['csds_rss1_title'];
	$csds_rss2_title = $options['csds_rss2_title'];
	$csds_rss3_title = $options['csds_rss3_title'];
	$csds_rss4_title = $options['csds_rss4_title'];
	$csds_rss5_title = $options['csds_rss5_title'];
	
	if( $csds_rss1_title <> "" ){
		$feedtitle[] = $csds_rss1_title;
	}
	if( $csds_rss2_title <> "" ){
		$feedtitle[] = $csds_rss2_title;
	}
	if ( $csds_rss3_title <> "" ){
		$feedtitle[] = $csds_rss3_title;
	}
	if ( $csds_rss4_title <> "" ){
		$feedtitle[] = $csds_rss4_title;
	}
	if ( $csds_rss5_title <> "" ){
		$feedtitle[] = $csds_rss5_title;
	}	
	
	$csds_rss1_url = $options['csds_rss1_url'];
	$csds_rss2_url = $options['csds_rss2_url'];
	$csds_rss3_url = $options['csds_rss3_url'];
	$csds_rss4_url = $options['csds_rss4_url'];
	$csds_rss5_url = $options['csds_rss5_url'];
	$csds_spliter = $options['csds_spliter'];
	$csds_target = $options['csds_target'];
	$csds_support = $options['csds_support'];	
	$feedsran = 0;
	$cnt=0;
	$doc = new DOMDocument();
	$spliter = $csds_spliter;
	$nodata = ' No data from this feed available at this time, check feed url or website feed please! ';
	foreach( $feeds as $feed ){		
		$doc->load( $feed );
		$feedsran += 1;
		$items = $doc->getElementsByTagName( "item" );
		$itemsListLength = $items->length;
		
		$feedname = $feedtitles[$i];
		if($itemsListLength > 0){
			if($i == 0 && $csds_support == "1"){	
				$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$display_link."'>" . $display_name . "</a>" . $spliter;
				$csds = $csds . $feedname . ' ';
			}elseif($i >= 1 && $csds_support == "1"){
				$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$display_link."'>" . $display_name . "</a>" . $spliter;
				$csds = $csds . ' ' . $feedname . ' ';
			}elseif($i == 0 && $csds_support == "2"){
				$csds = $csds . $feedname . $spliter;
			}elseif($i >= 1 && $csds_support == "2"){
				$csds = $csds . $spliter . $feedname . ' ';
			}
		}elseif($itemsListLength == 0){
			if($i == 0 && $csds_support == "1"){	
				$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$display_link."'>" . $display_name . "</a>" . $spliter;
				$csds = $csds . $feedname . $spliter . $nodata;
			}elseif($i >= 1 && $csds_support == "1"){
				$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$display_link."'>" . $display_name . "</a>" . ' -//- ';
				$csds = $csds . ' ' . $feedname . $spliter . $nodata;
			}elseif($i == 0 && $csds_support == "2"){
				$csds = $csds . $feedname . @$spliter . $nodata;
			}elseif($i >= 1 && $csds_support == "2"){
				$csds = $csds . ' -//- ' . $feedname . $spliter . $nodata;
			}
			$i += 1;
		}
				
		foreach( $items as $item ){
			if($itemsListLength > 0){
				$paths = $item->getElementsByTagName( "title" );
				//$title = csds_cdata($paths->item(0)->nodeValue);
				$title = mysql_real_escape_string(csds_cdata($paths->item(0)->nodeValue));
				$title = stripslashes($title);
				$paths = $item->getElementsByTagName( "link" );
				$links = mysql_real_escape_string(csds_cdata($paths->item(0)->nodeValue));
				$links = stripslashes($links);
				if($count >= 0){
					$spliter = $csds_spliter;
				}
				$csds = $csds . $spliter . "<a target='".$csds_target."' href='".$links."'>" . $title . "</a>";
				$count += 1;
			}
			if($count == $csds_news_items){
				$i += 1;
				$count = 0;
				break;
			}elseif($itemsListLength == 0){
				$spliter = $csds_spliter;
				$csds = $csds . $spliter . ' No feed data currently available ' . $spliter ;
				$count = 0;
				$i += 1;
			}
		}
	}
	$csds_marquee = $csds_marquee . "<div style='padding:3px;' class='csds_marquee'>";
	$csds_marquee = $csds_marquee . "<marquee style='$csds_style' scrollamount='$csds_scrollamount' scrolldelay='$csds_scrolldelay' direction='$csds_direction' onmouseover='this.stop()' onmouseout='this.start()'>";
	$csds_marquee = $csds_marquee . $csds;
	$csds_marquee = $csds_marquee . "</marquee>";
	$csds_marquee = $csds_marquee . "</div>";
	echo $csds_marquee;	
}

function csds_options_array(){
	$options = array(
		'csds_title'			=>	'Marquee Style RSS News Ticker',
		'csds_scrollamount'		=>	'2',
		'csds_scrolldelay'		=>	'5',
		'csds_direction'		=>	'left',
		'csds_news_items'		=>	'10',
		'csds_style'			=>	'color:#FF0000;font:Arial;',
		'csds_rss1_title'		=>	'Creative Software Design Solutions',
		'csds_rss2_title'		=>	'WordPress.Org',
		'csds_rss3_title'		=>	'',
		'csds_rss4_title'		=>	'',
		'csds_rss5_title'		=>	'',
		'csds_rss1_url'			=>	'http://creative-software-design-solutions.com/feed/',
		'csds_rss2_url'			=>	'http://wordpress.org/news/feed/',
		'csds_rss3_url'			=>	'',
		'csds_rss4_url'			=>	'',
		'csds_rss5_url'			=>	'',
		'csds_spliter'			=>	' -//- ',
		'csds_support'			=>	'1'
		
	);
	
	return $options;
}


function csds_install() 
{
	$options = get_option('csds_marquee');
	if( empty( $options ) ){
		$title = get_option('csds_title');
		if( empty( $title ) ){
			$options = csds_options_array();
		}else{
			csds_marquee_update_options();
			$options = get_option('csds_marquee');
		}
	}
	
	update_option(	'csds_marquee', $options );
	/*
	add_option('csds_title', "Marquee Style RSS News Ticker");
	add_option('csds_scrollamount', "2");
	add_option('csds_scrolldelay', "5");
	add_option('csds_direction', "left");
	add_option('csds_news_items', "10");
	add_option('csds_style', "color:#FF0000;font:Arial;");
	add_option('csds_rss1_title', "Creative Software Design Solutions");
	add_option('csds_rss2_title', "WordPress.Org");
	add_option('csds_rss3_title', "");
	add_option('csds_rss4_title', "");
	add_option('csds_rss5_title', "");
	add_option('csds_rss1_url', "http://creative-software-design-solutions.com/feed/");
	add_option('csds_rss2_url', "http://wordpress.org/news/feed/");
	add_option('csds_rss3_url', "");
	add_option('csds_rss4_url', "");
	add_option('csds_rss5_url', "");
	add_option('csds_spliter', " -//- ");
	add_option('csds_target', "_blank");
	add_option('csds_support', "1");
	*/
}

function csds_marquee_update_options(){

	$options = get_option('csds_marquee');
		
	if( empty( $options ) ){
		$title = get_option('csds_title');
		$scroll_amount = get_option('csds_scrollamount');
		$scroll_delay = get_option('csds_scrolldelay');
		$direction = get_option('csds_direction');
		$news_cnt = get_option('csds_news_items');
		$style = get_option('csds_style');
		$title_1 = get_option('csds_rss1_title');
		$title_2 = get_option('csds_rss2_title');
		$title_3 = get_option('csds_rss3_title');
		$title_4 = get_option('csds_rss4_title');
		$title_5 = get_option('csds_rss5_title');
		$url_1 = get_option('csds_rss1_url');
		$url_2 = get_option('csds_rss2_url');
		$url_3 = get_option('csds_rss3_url');
		$url_4 = get_option('csds_rss4_url');
		$url_5 = get_option('csds_rss5_url');
		$splitter = get_option('csds_spliter');
		$target = get_option('csds_target');
		$support = get_option('csds_support');
	
		$options['csds_title'] = $title;
		$options['csds_scrollamount'] = $scroll_amount;
		$options['csds_scrolldelay'] = $scroll_delay;
		$options['csds_direction'] = $direction;
		$options['csds_news_items'] = $news_cnt;
		$options['csds_style'] = $style;
		$options['csds_rss1_title'] = $title_1;
		$options['csds_rss2_title'] = $title_2;
		$options['csds_rss3_title'] = $title_3;
		$options['csds_rss4_title'] = $title_4;
		$options['csds_rss5_title'] = $title_5;
		$options['csds_rss1_url'] = $url_1;
		$options['csds_rss2_url'] = $url_2;
		$options['csds_rss3_url'] = $url_3;
		$options['csds_rss4_url'] = $url_4;
		$options['csds_rss5_url'] = $url_5;
		$options['csds_spliter'] = $splitter;
		$options['csds_target'] = $target;
		$options['csds_support'] = $support;
		
		// adding new options
		update_option('csds_marquee', $options );
		
		// deleting old options
		delete_option('csds_title');
		delete_option('csds_scrollamount');
		delete_option('csds_scrolldelay');
		delete_option('csds_direction');
		delete_option('csds_news_items');
		delete_option('csds_style');
		delete_option('csds_rss1_title');
		delete_option('csds_rss2_title');
		delete_option('csds_rss3_title');
		delete_option('csds_rss4_title');
		delete_option('csds_rss5_title');
		delete_option('csds_rss1_url');
		delete_option('csds_rss2_url');
		delete_option('csds_rss3_url');
		delete_option('csds_rss4_url');
		delete_option('csds_rss5_url');
		delete_option('csds_spliter');
		delete_option('csds_target');
		delete_option('csds_support');
	}
}

function csds_widget($args){
	$options = get_option('csds_marquee');
	
	if( empty( $options ) ){
		csds_marquee_update_options();
	}
	
	extract($args);
	if( $options['csds_title'] <> ""){
		echo $before_widget;
		echo $before_title;
		echo $options['csds_title'];
		echo $after_title;
	}
	rssshow();
	if( $options['csds_title'] <> ""){
		echo $after_widget;
	}
}
	
function csds_control(){
	echo "Marquee Style RSS News Ticker";
	echo "<br>";
	echo "<a href='http://creative-software-design-solutions.com/creative-software-design-solutions-marquee-news-ticker-wordpress-plugin/' target='_blank'>Check official website for live demo</a>";
	echo "<br>";
}

function csds_widget_init(){
	if(function_exists('wp_register_sidebar_widget')){
		wp_register_sidebar_widget('marquee-style-rss-news-ticker', 'Marquee Style RSS News Ticker', 'csds_widget');
	}
	
	if(function_exists('wp_register_widget_control')){
		wp_register_widget_control('marquee-style-rss-news-ticker', array('Marquee Style RSS News Ticker', 'widgets'), 'csds_control');
	} 
}

function csds_deactivation(){

}

function csds_option(){
	global $wpdb;
	global $current_user;
	$current_user = wp_get_current_user();
	if( !current_user_can( 'manage_options', $current_user->ID ) ){	
		wp_die(__('You do not have permissions to modify this plugins settings, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide'));
	}else{
		echo '<h2>Marquee Style RSS News Ticker</h2>';
		$options = get_option('csds_marquee');
		
		if( empty( $options ) ){
			csds_marquee_update_options();
		}
		
		$csds_title = $options['csds_title'];
		
		$csds_scrollamount = $options['csds_scrollamount'];
		$csds_scrolldelay = $options['csds_scrolldelay'];
		$csds_direction = $options['csds_direction'];
		$csds_news_items = $options['csds_news_items'];
		$csds_style = $options['csds_style'];
		
		$csds_rss1_title = $options['csds_rss1_title'];
		$csds_rss2_title = $options['csds_rss2_title'];
		$csds_rss3_title = $options['csds_rss3_title'];
		$csds_rss4_title = $options['csds_rss4_title'];
		$csds_rss5_title = $options['csds_rss5_title'];
		
		$csds_rss1_url = $options['csds_rss1_url'];
		$csds_rss2_url = $options['csds_rss2_url'];
		$csds_rss3_url = $options['csds_rss3_url'];
		$csds_rss4_url = $options['csds_rss4_url'];
		$csds_rss5_url = $options['csds_rss5_url'];

		$csds_spliter = $options['csds_spliter'];
		$csds_target = $options['csds_target'];
		$csds_support = $options['csds_support'];
		
		if (@$_POST['csds_submit']){
			$options['csds_title'] = stripslashes($_POST['csds_title']);
			
			$options['csds_scrollamount'] = stripslashes($_POST['csds_scrollamount']);
			$options['csds_scrolldelay'] = stripslashes($_POST['csds_scrolldelay']);
			$options['csds_direction'] = stripslashes($_POST['csds_direction']);
			$options['csds_news_items'] = stripslashes($_POST['csds_news_items']);
			$options['csds_style'] = stripslashes($_POST['csds_style']);

			$options['csds_rss1_title'] = stripslashes($_POST['csds_rss1_title']);
			$options['csds_rss2_title'] = stripslashes($_POST['csds_rss2_title']);
			$options['csds_rss3_title'] = stripslashes($_POST['csds_rss3_title']);
			$options['csds_rss4_title'] = stripslashes($_POST['csds_rss4_title']);
			$options['csds_rss5_title'] = stripslashes($_POST['csds_rss5_title']);
			
			$options['csds_rss1_url'] = stripslashes($_POST['csds_rss1_url']);
			$options['csds_rss2_url'] = stripslashes($_POST['csds_rss2_url']);
			$options['csds_rss3_url'] = stripslashes($_POST['csds_rss3_url']);
			$options['csds_rss4_url'] = stripslashes($_POST['csds_rss4_url']);
			$options['csds_rss5_url'] = stripslashes($_POST['csds_rss5_url']);
			$options['csds_spliter'] = stripslashes($_POST['csds_spliter']);
			$options['csds_target'] = stripslashes($_POST['csds_target']);
			$options['csds_support'] = stripslashes($_POST['csds_support']);
			
			update_option('csds_marquee', $options );
			echo '<div id="message" class="updated"><b>Updated</b>: Marquee Style RSS News Ticker Settings Updated!</div>';
			
		}
		
		echo '<form name="csds_form" method="post" action="">';
		
		echo '<p><b>Title :</b><br><input  style="width: 250px;" type="text" value="';
		echo $csds_title . '" name="csds_title" id="csds_title" /></p>';
		
		echo '<p><b>Scroll amount :</b><br><input  style="width: 100px;" type="text" value="';
		echo $csds_scrollamount . '" name="csds_scrollamount" id="csds_scrollamount" /></p>';
		
		echo '<p><b>Scroll delay :</b><br><input  style="width: 100px;" type="text" value="';
		echo $csds_scrolldelay . '" name="csds_scrolldelay" id="csds_scrolldelay" /></p>';
		
		echo '<p><b>Scroll direction :</b><br><input  style="width: 100px;" type="text" value="';
		echo $csds_direction . '" name="csds_direction" id="csds_direction" /> (left/right)</p>';

		echo '<p><b>News Items, articles or posts to display from feed :</b><br><input  style="width: 100px;" type="text" value="';
		echo $csds_news_items . '" name="csds_news_items" id="csds_news_items" /> (Default 10: 1,2, any integer)</p>';
		
		echo '<p><b>Scroll style :</b><br><input  style="width: 250px;" type="text" value="';
		echo $csds_style . '" name="csds_style" id="csds_style" /></p>';
		
		echo '<p><b>Splitter :</b><br><input  style="width: 100px;" type="text" value="';
		echo $csds_spliter . '" name="csds_spliter" id="csds_spliter" /></p>';
		
		echo '<p><b>Target :</b><br><input  style="width: 100px;" type="text" value="';
		echo $csds_target . '" name="csds_target" id="csds_target" /> (_blank, _parent, _new)</p>';
		
		echo '<p><b>Rss feed 1 Title:</b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss1_title . '" name="csds_rss1_title" id="csds_rss1_title" /> (RSS1) <br>This is default for widget</p>';
		
		echo '<p><b>Rss feed 1 URL:</b> <br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss1_url . '" name="csds_rss1_url" id="csds_rss1_url" />';
		
		echo '<p><b>Rss feed 2 Title:</b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss2_title . '" name="csds_rss2_title" id="csds_rss2_title" /> (RSS2)</p>';
		
		echo '<p><b>Rss feed 2 URL: </b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss2_url . '" name="csds_rss2_url" id="csds_rss2_url" />';
		
		echo '<p><b>Rss feed 3 Title:</b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss3_title . '" name="csds_rss3_title" id="csds_rss3_title" /> (RSS3)</p>';
		
		echo '<p><b>Rss feed 3 URL: </b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss3_url . '" name="csds_rss3_url" id="csds_rss3_url" />';
		
		echo '<p><b>Rss feed 4 Title: </b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss4_title . '" name="csds_rss4_title" id="csds_rss4_title" /> (RSS4)</p>';
		
		echo '<p><b>Rss feed 4 URL: </b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss4_url . '" name="csds_rss4_url" id="csds_rss4_url" />';
		
		echo '<p><b>Rss feed 5 Title: </b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss5_title . '" name="csds_rss5_title" id="csds_rss5_title" /> (RSS5)</p>';
		
		echo '<p><b>Rss feed 5 URL: </b><br><input  style="width: 350px;" type="text" value="';
		echo $csds_rss5_url . '" name="csds_rss5_url" id="csds_rss5_url" />';
		
		?>
		<p><b>Show Plugin Support: </b><input type="radio" id="csds_support" name="csds_support"  value="1" <?php
		if ($csds_support == 1) echo 'checked' ;?> /> <b>Yes</b>
		<input type="radio" id="csds_support" name="csds_support"  value="2" <?php
		if ($csds_support == 2) echo 'checked' ; ?> /> <b>No</b>
		

		<?php
		echo '<br>';
		echo '<br>';


		echo '<input name="csds_submit" id="csds_submit" lang="publish" class="button-primary" value="Update" type="Submit" />';
		echo '</form>';
		?>
		<h2>Plugin configuration help</h2>
		<ul>
			<li><a href="http://creative-software-design-solutions.com/creative-software-design-solutions-marquee-news-ticker-wordpress-plugin/" target="_blank">Drag and drop the widget</a></li>
			<li><a href="http://creative-software-design-solutions.com/creative-software-design-solutions-marquee-news-ticker-wordpress-plugin/" target="_blank">Short code for posts and pages</a></li>
			<li><a href="http://creative-software-design-solutions.com/creative-software-design-solutions-marquee-news-ticker-wordpress-plugin/" target="_blank">Add directly in the theme</a></li>
		</ul>
		<h2>Check official website</h2>
		<ul>
			<li><a href="http://creative-software-design-solutions.com/creative-software-design-solutions-marquee-news-ticker-wordpress-plugin/" target="_blank">Check official website for live demo</a></li>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="6BCZESUXLS9NN">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

		</ul>
		<?php
	}
}

function plugin_version() {
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

function csds_add_to_menu() 
{
	add_options_page('Marquee Style RSS News Ticker', 'Marquee Style RSS News Ticker', 'manage_options', __FILE__, 'csds_option' );
}

add_action('admin_menu', 'csds_add_to_menu');
add_action("plugins_loaded", "csds_widget_init");
register_activation_hook(__FILE__, 'csds_install');
register_deactivation_hook(__FILE__, 'csds_deactivation');
add_action('init', 'csds_widget_init');
?>