<div>
    <select id="ddl_ect_mtb_template_id" name="ect_mtb_template_id">
<?php
$templates = get_posts(array(
    'post_type' => 'ec-template',
    'post_status' => 'publish',
    'order_by' => 'title',
    'order' => 'ASC'
));
foreach($templates as $template):
?>
        <option value="<?php echo $template->ID; ?>"><?php echo $template->post_title; ?></option>
<?php
endforeach;
?>
    </select>
</div>
<div>
    <button id="btn_ect_mtb_load" class="button">Load Template</button>
</div>
<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('#btn_ect_mtb_load').click(function(event){
                event.preventDefault();
                $.ajax({
                    'data': {
                        'action': 'ect_get_contents',
                        'template_id': $('#ddl_ect_mtb_template_id').val()
                    },
                    'dataType': 'json',
                    'error': function(){},
                    'global': false,
                    'success': function(data){
                        if(data.success == 1){
                            switchEditors.go('content', 'html');
                            $('#title').val(unescape(data.title)).focus().blur();
                            $('#content').val(unescape(data.content));
                            $('#excerpt').val(unescape(data.excerpt));
                            switchEditors.go('content', 'tinymce');
                            
                            //switchEditors.go('content', 'html');
                            //var theTitle = document.getElementById('title');
                            //var thePost = document.getElementById('content');
                            //var theExcerpt = document.getElementById('excerpt');
                            //theExcerpt.value = unescape('');
                            //theTitle.value = unescape('');
                            //thePost.value = unescape('');
                            //switchEditors.go('content', 'tinymce');
                        }else{
                            alert(data.message);
                        }
                    },
                    'timeout': 3000,
                    'type': 'POST',
                    'url': '<?php bloginfo('url'); ?>/wp-admin/admin-ajax.php'
                });
            });
        });
    })(jQuery);
</script>