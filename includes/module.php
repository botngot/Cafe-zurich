<?php $root = 'template-parts/';

  if( have_rows('blocks') ):

    while ( have_rows('blocks') ) : the_row();

        $layout = get_row_layout();

        include $root . $layout .'.php';

    endwhile;

endif;

?>
