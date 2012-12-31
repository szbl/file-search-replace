<?php $this->get( 'header.php' ); ?>

<pre id="preview"><?php echo str_replace( array( '[[[[[', ']]]]]' ), array( '<span class="highlight">', '</span>' ), htmlentities( $this->contents ) ); ?></pre>

<?php $this->get( 'footer.php' ); ?>