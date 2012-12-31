<?php $this->get( 'header.php' ); ?>

<h1><?php echo count( $files ); ?> Files Cleaned!</h1>

<p>You have successfully removed the following string from <?php echo count( $files ); ?> files:</p>

<p><textarea class="code"><?php echo htmlentities( $s ); ?></textarea></p>

<h4>Files Changed:</h4>
<table class="form-table">
<tbody>
<?php foreach ( $files as $file ) : ?>
<tr>
	<td>
		<code>
			<?php echo htmlentities( $file ); ?>
		</code>
	</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php $this->get( 'footer.php' ); ?>
