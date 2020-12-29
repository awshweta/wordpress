<?php
$header_color_setting = get_theme_mod( 'header_color_setting' );
$footer_color_setting = get_theme_mod( 'footer_color_setting' );
$button_color_setting = get_theme_mod( 'button_color_setting' );
?>

<style>
header {
    background: <?php echo $header_color_setting; ?> !important;
}
.footer {
    background: <?php echo $footer_color_setting; ?> !important;
}
#mwa_banner_slider .mwa_link_bnr {
    background: <?php echo $button_color_setting; ?>;
    border: 2px solid <?php echo $button_color_setting; ?>;
}
#mwa_banner_slider .mwa_link_bnr:hover {
    background: transparent;
    border: 2px solid <?php echo $button_color_setting; ?>;
    color: <?php echo $button_color_setting; ?>;
}
#callout .mwa_link_bnr {
    background: <?php echo $button_color_setting; ?>;
    border: 1px solid <?php echo $button_color_setting; ?>;
}
#callout .mwa_link_bnr:hover {
    background: transparent;
    border: 1px solid <?php echo $button_color_setting; ?>;
    color: <?php echo $button_color_setting; ?>;
}
a.blog_link {
    border: 1px solid <?php echo $button_color_setting; ?>;
    background: <?php echo $button_color_setting; ?>;
}
a.blog_link:hover {
    color: <?php echo $button_color_setting; ?>;
    border: 1px solid <?php echo $button_color_setting; ?>;
}
.astral_blog a.single {
    border: 1px solid <?php echo $button_color_setting; ?>;
    background: <?php echo $button_color_setting; ?>;
}
.blog_page a.single:hover {
    border: 1px solid <?php echo $button_color_setting; ?>;
}
.searchform input[type="submit"] {
    background: <?php echo $button_color_setting; ?> !important;
}   
#mm_single_submit {
    background: <?php echo $button_color_setting; ?> !important;
}
</style>