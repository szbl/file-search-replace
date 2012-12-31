<?php $this->get( 'header.php' ); ?>

	<h1>File Search &amp; Replace</h1>
	
	<form method="post" action="" class="default">
		
		<table class="form-table">
		<tbody>
		<tr>
			<th>
				<label for="file-extension">
					Directory
				</label>
			</th>
			<td>
				<input type="text" class="full" id="directory" name="directory" value="<?php
					if ( isset( $clean['directory'] ) )
						echo htmlentities( $clean['directory'] );
				?>">
				<?php if ( isset( $errors['directory'] ) ) : ?>
				<span class="error">
					<?php echo $errors['directory']; ?>
				</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="file-extension">
					File Extension
				</label>
			</th>
			<td>
				<input type="text" size="4" id="file-extension" name="file_extension" value="<?php
					if ( isset( $clean['file_extension'] ) )
						echo htmlentities( $clean['file_extension'] );
				?>">
				<?php if ( isset( $errors['file_extension'] ) ) : ?>
				<span class="error">
					<?php echo $errors['file_extension']; ?>
				</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="s">
					Search String:
				</label>
			</th>
			<td>
				<textarea id="s" name="s" class="code"><?php
					if ( isset( $clean['s'] ) )
						echo htmlentities( $clean['s'] );
				?></textarea>
				<?php if ( isset( $errors['s'] ) ) : ?>
				<span class="error">
					<?php echo $errors['s']; ?>
				</span>
				<?php endif; ?>
			</td>
		</tr>
		</tbody>
		</table>
		
		<p class="aligncenter">
			<input type="submit" id="btn-submit" class="button button-primary" value="Search &raquo;">
		</p>
	</form>
		
<?php $this->get( 'footer.php' ); ?>