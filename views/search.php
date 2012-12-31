<?php $this->get( 'header.php' ); ?>

<h1>Search Files Yielded <?php echo count( $results ); ?> Results</h1>

<p>
	Search directory: <code><?php echo $dir; ?></code>.
	<br>
	Search file extension: <code><?php echo $ext; ?></code>.
</p>
<p>
	Search String:
	<br>
	<textarea class="code full"><?php echo htmlentities( $s ); ?></textarea>
</p>

<?php if ( count( $results ) > 0 ) : ?>
	
	<h2><?php echo count( $results ); ?> Found Files:</h2>
	
	<form method="post" action="?action=clean" class="replace">
		
		<p>Check the files for which you'd like to perform a clean-up. Click a file to view a plain-text version of it's context in a new window.</p>
	
		<table class="form-table" id="summary">
		<thead>
		<tr>
			<th><input type="checkbox"></th>
			<th>File Name</th>
			<th>More</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $results as $file ) : ?>
		<tr>
			<th><input type="checkbox" name="files[]" value="<?php echo htmlentities( $file ); ?>"></th>
			<td class="filename">
				<code>
					<a class="preview" href="#" title="<?php echo htmlentities( $file ); ?>" target="_blank">
						<?php echo $file; ?>
					</a>
				</code>
			</td>
			<td class="filename">
				<a class="preview-clean" href="#" title="<?php echo htmlentities( $file ); ?>" target="_blank">
					Preview Clean File
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
		
		<input type="hidden" name="s" value="<?php echo htmlentities( $s ); ?>">
		<p class="aligncenter">
			<input type="submit" value="Perform Replacement on Checked Files &raquo;">
		</p>
	</form>
	
	
	<form id="previewer" method="post" target="_blank" action="?action=preview">
		<input type="hidden" id="preview-search" name="s" value="<?php echo htmlentities( $s ); ?>">
		<input type="hidden" id="preview-file" name="file" value="">
		<input type="hidden" id="preview-clean" name="clean" value="0">
	</form>
	
<?php else : ?>
	
	<p><em>No files were found with the string you requested.</em></p>
	
<?php endif; ?>

<?php $this->get( 'footer.php' ); ?>