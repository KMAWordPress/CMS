<?php get_header();?>
<div id="main">
	<div id="content">
	        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p >
                <?php the_time('M d Y'); ?>
            </p>
            <h2 class="title"><?php _e("404 - Сервер не может найти ето!", "voidy"); ?></h2>
            <div class="entry">
              <p>			  
				<?php _e("Запись или страница, которую Вы ищете, на данный момент не существует. Это может быть связано с тем что ее или удалили или перенесли по другому адресу.", "voidy" ); ?>
			  </p>
              <p>
			  <?php _e("Пожалуйста просмотрите архивы или же используйте поиск, возможно там вы что-то найдете.", "voidy") ; ?>
			  </p>
      			</div>
            <p class="comments">
              <?php _e("Опубликовано как \"Не найдено\"", "voidy") ; ?>
            </p>	          
	        </div>      
	</div>
  <?php get_sidebar();?>
  <?php get_footer();?>