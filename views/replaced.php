<?php $this->get( 'header.php' ); ?>

	<h1><?php echo count( $files ); ?> Files Cleaned</h1>
	
	<p>Files cleaned:</p>
	
	<table class="form-table" id="summary">
	<thead>
	<tr>
		<th>File Name</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ( $files as $file ) : ?>
	<tr>
		<td class="filename">
			<code>
				<a class="preview" href="#" title="<?php echo htmlentities( $file ); ?>" target="_blank">
					<?php echo $file; ?>
				</a>
			</code>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>

	<form id="previewer" method="post" target="_blank" action="?action=preview">
		<input type="hidden" id="preview-search" name="s" value="<?php echo htmlentities( $s ); ?>">
		<input type="hidden" id="preview-file" name="file" value="">
		<input type="hidden" id="preview-clean" name="clean" value="0">
	</form>

<?php $this->get( 'footer.php' ); ?>