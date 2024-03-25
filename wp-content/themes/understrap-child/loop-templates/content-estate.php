<a href="<?=get_permalink($post) ?>" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
        <h4 class="mb-2"><?php the_title(); ?></h4>
    </div>
    <?php if( 
        get_field('re_square') ||
        get_field('re_price') ||
        get_field('re_address') ||
        get_field('re_living_space') ||
        get_field('re_floor')
        ): ?>
        <ul class="list-unstyled mt-0 px-0">
            <?php if( get_field('re_square')): ?>
                <li><strong>Площадь:</strong> <?php the_field('re_square'); ?> м<sup>2</sup></li>
            <?php endif; ?>
            <?php if( get_field('re_price')): ?>
                <li><strong>Стоимость:</strong> <?php the_field('re_price'); ?> ₽</li>
            <?php endif; ?>
            <?php if( get_field('re_address')): ?>
                <li><strong>Адрес:</strong> <?php the_field('re_address'); ?></li>
            <?php endif; ?>
            <?php if( get_field('re_living_space')): ?>
                <li><strong>Жилая площадь:</strong> <?php the_field('re_living_space'); ?> м<sup>2</sup></li>
            <?php endif; ?>
            <?php if( get_field('re_floor')): ?>
                <li><strong>Этаж:</strong> <?php the_field('re_floor'); ?></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</a>