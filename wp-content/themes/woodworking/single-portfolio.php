<?php 

get_template_part('template_part/portfolio', 'header');
get_template_part('template_part/portfolio', 'sidebar');
?>

<div class="post">
    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="meta">Posted by <a href="#"><?php the_author(); ?></a> on <?php 
    $val = get_the_date();
    echo $val;?>
    &nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
    <div class="entry">

    <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php the_content(); ?> </p>
    </div>
</div>
<?php
comments_template( '/comments.php' ); 
get_template_part('template_part/portfolio', 'footer'); ?>