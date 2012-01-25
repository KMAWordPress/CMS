<?php

	require_once('../../../wp-load.php');
	
	$linkid = intval($_GET['linkid']);
	$itemcount = intval($_GET['previewcount']);
	
	$link = get_bookmark( $linkid );
	
	$genoptions = get_option('LinkLibraryGeneral');

	include_once(ABSPATH . WPINC . '/feed.php');

	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed($link->link_rss);
	if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity($itemcount); 

		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $maxitems);
		
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo (empty($_GET['feed'])) ? 'RSS_PHP' : 'RSS_PHP: ' . $link->link_name; ?></title>

<!-- META HTTP-EQUIV -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8; ?>" />
<meta http-equiv="imagetoolbar" content="false" />

<?php if ($genoptions['stylesheet'] != ''): ?>
	<style id='LinkLibraryStyle' type='text/css'>
	<?php echo stripslashes($genoptions['fullstylesheet']); ?>
	</style>
<?php endif; ?>

</head>

<body>
	<div id="ll_rss_preview_results">
		<?php if ($rss_items): ?>
			<?php foreach($rss_items as $item): ?>
				<div class="ll_rss_preview_title" style="padding:0 5px 5px;">
					<h1><a target="feedwindow" href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a><div class='ll_rss_preview_date'><?php echo $item->get_date('j F Y | g:i a'); ?></div></h1>
					<div class='ll_rss_preview_content'><?php echo $item->get_description(); ?></div>
				</div>
				<br />
			<?php 
				endforeach;
			?>
			<br />
			<div>
				<a class="ll_rss_preview_button" target="feedwindow" href="<?php echo $link->link_rss; ?>"><span>More News from this Feed</span></a> <a class="ll_rss_preview_button" target="sitewindow" href="<?php echo $link->link_url; ?>"><span>See Full Web Site</span></a>
			</div>
			<br />
			<br />
		<?php endif; ?>
	</div>
</body>
</html>