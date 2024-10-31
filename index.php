<?php
/*
Plugin Name: SEO Headers
Plugin URI: http://www.mywebtronics.com/atlanta-seo/seo-header-plugin/
Description: Allows for changing of header titles without changing page name. 
Version: 1.0
Author: Jason Capshaw
Author URI: http://www.mywebtronics.com
  /*  Copyright 2009  Jason Capshaw (email: jason@mywebtronics.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
//heading function
function heading($h1){
//get the id of the current post
$id = get_the_ID();

//find out the title of the current post, because get_the_title() cannot be used and the value passed from the filter will not be the same
global $table_prefix;
$sql = "SELECT `post_title` FROM `".$table_prefix."posts` WHERE `ID` = '$id';";
$query = mysql_query($sql) or die('Error, insert query failed' . mysql_error());
$row = mysql_fetch_array($query);
$title = $row['post_title']; 

//SQL to determine site URL, so we can make sure not to change the title in the admin section
$sql = " SELECT option_value
FROM `".$table_prefix."options`
where option_name = 'siteurl'";
$query = mysql_query($sql) or die('Error, insert query failed' . mysql_error());
$row = mysql_fetch_array($query);
$siteurl = $row['option_value'];
$domain = $_SERVER['HTTP_HOST'];
$path = $_SERVER['SCRIPT_NAME'];

$url = "http://" . $domain . $path . "";

if ($url != "".$siteurl."/wp-admin/edit.php" ) 
{
   if ($url != "".$siteurl."/wp-admin/edit-pages.php") {
        //make sure that the title of the current page is the only thing changed, keeps links to pages or posts that use the_title() from being set to our meta value
        if ($h1 == $title) {
              //check and see if the post has any meta data using SEO_heading
	          if (get_post_meta($id, "SEO_heading", true) != '') {
	          //if it does, lets get the value and assign it to the title
	          $h1 = get_post_meta($id, "SEO_heading", true);
	          }
        } 
    }	 
}
return ($h1);
}
add_filter('the_title','heading');
?>