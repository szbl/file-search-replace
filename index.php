<?php
/*
Application Name: File Search & Replace
Description: Quick script for searching for specific types of files on your server and running replacements. Ideal for quick and temporary malware solutions.
Version: 0.2
License: GPL2
*/

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'class.file-search-replace.php';
File_Search_Replace::init();
?>