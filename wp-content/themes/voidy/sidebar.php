<?php
global $options, $option_values;

foreach ($options as $value) {
	if($value['id'] != "voidy_temp"){
	    if (empty($option_values[ $value['id']])) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = $option_values[ $value['id'] ]; 
		}
	}
}
?>
<div id="sidebar1" class="sidecol">
	<ul>
	 <?php if ($voidy_sidebar_text && $voidy_hide_sidebar_text != "true") { 
		echo "<li><p>".stripslashes($voidy_sidebar_text)."</p></li>";
	} ?>
	
	<?php if ($voidy_show_email && $voidy_show_email == "true") { ?>
	<li><form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $voidy_feedburner ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
	<p  style="padding: 0px;"><?php _e("Get updates by email", "voidy" ); ?></p>
		<input type="text" class="textbox with-button" name="email" value="Введите свой ​​адрес электронной почты"
		onblur="if (this.value == '') {this.value = 'Введите свой ​​адрес электронной почты';}"  
		onfocus="if (this.value == 'Введите свой ​​адрес электронной почты') {this.value = '';}" />
		<input type="hidden" value="<?php echo $voidy_feedburner ?>" name="uri"/>
		<input type="hidden" name="loc" value="en_US"/>
		<input type="submit" value="Go" class="go" />
	</form></li>
	<?php } ?>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
<li>
	<h2><?php _e('Последние записи', "voidy" ); ?></h2>
	<ul><?php wp_get_archives("type=postbypost&limit=6")?></ul>
</li>
<li>
    <h2><?php _e('Канал', "voidy" ); ?></h2>
    <ul>
      <li class="feed"><a title="RSS Канал записей" href="<?php bloginfo('rss2_url'); ?>"><?php _e('RSS Записей', "voidy" ); ?></a></li>
      <li class="feed"><a title="RSS Канал комментариев" href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('RSS Комментариев', "voidy" ); ?></a></li>
    </ul>
  </li>
<li>
	<?php $search_text = __("Поиск по сайту", "voidy" ); ?> 
	<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/"> 
	<input type="text" value="<?php echo $search_text; ?>"  
		name="s" id="s"  class="with-button"
		onblur="if (this.value == '')  
		{this.value = '<?php echo $search_text; ?>';}"  
		onfocus="if (this.value == '<?php echo $search_text; ?>')  
		{this.value = '';}" /> 
		<input type="submit" value="Вперед" class="go" />
	<input type="hidden" id="searchsubmit" /> 

	</form>
  </li>
  <li>
    <h2>
      <?php _e('Категории', "voidy" ); ?>
    </h2>
    <ul>
      <?php wp_list_categories('title_li=');    ?>
    </ul>
  </li>
  <li>
    <h2>
      <?php _e('Ежемесячно', "voidy" ); ?>
    </h2>
    <ul>
      <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
    </ul>
  </li>
  <li>
    <h2><?php _e('Страницы', "voidy" ); ?></h2>
    <ul>
      <?php wp_list_pages('title_li=' ); ?>
    </ul>
  </li>
    <?php endif; ?>
</ul>
</div>