<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-4">
            <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail', ['class' => "card-img"] ); ?>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <a href="<?=get_permalink() ?>">
                    <h5 class="card-title"><?php the_title(); ?></h5>
                </a>
                <div class="card-text"><?php the_excerpt(); ?></div>
            </div>
        </div>
    </div>
</div>