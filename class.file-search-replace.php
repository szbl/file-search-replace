<?php
class File_Search_Replace
{
	
	public static $instance;
	
	public static function init()
	{
		if ( is_null( self::$instance ) )
			self::$instance = new File_Search_Replace();
		
		$action = isset( $_GET['action'] ) ? $_GET['action'] : null;
		switch ( $action )
		{
			case 'clean':
				self::$instance->do_clean();
				break;
			
			case 'preview':
				self::$instance->preview();
				break;
			
			case 'search':
				$this->search();
				break;
			default:
				self::$instance->main();
				break;
		}
	}
	
	public function redirect( $url, $code )
	{
		switch ( $code )
		{
			case 301:
				header( 'HTTP/1.1 301 Moved Permanently' );
				break;
			case 303:
				header( 'HTTP/1.1 303 See Other' );
				break;
			default:
				header( 'HTTP/1.1 302 Moved Temporarily' );
				break;
		}
		header( 'Location: ' . $url );
		die;
	}
	
	public function render( $file )
	{
		$path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . basename( $file );
		if ( !file_exists( $path ) )
			return false;
		ob_start();
		if ( isset( $this->extract ) && is_array( $this->extract ) )
			extract( $this->extract );
		include $path;
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function get( $file )
	{
		echo $this->render( $file );
	}
	
	public function stripslashes_deep( $var )
	{
		if ( !is_array( $var ) )
			return get_magic_quotes_gpc() ? stripslashes( $var ) : $var;
		foreach ( $var as $key => $val )
			$var[ $key ] = $this->stripslashes_deep( $val );
		return $var;
	}
	
	public function main()
	{
		if ( sizeof( $_POST ) )
		{
			$clean = $this->stripslashes_deep( $_POST );
			$errors = array();
			
			if ( empty( $clean['directory'] ) || !is_dir( $clean['directory'] ) )
				$errors['directory'] = 'Please enter valid file directory.';
				
			if ( empty( $clean['file_extension'] ) )
				$errors['file_extension'] = 'Please enter a file extension.';
				
			if ( empty( $clean['s'] ) )
				$errors['s'] = 'Please enter a string for which to search.';

			if ( count( $errors ) == 0 )
				return $this->search( $clean );
				
			$this->extract = array(
				'clean' => $clean,
				'errors' => $errors
			);
		}
		else 
		{
			$this->extract = array(
				'clean' => array(
					'directory' =>	realpath( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR )
									. DIRECTORY_SEPARATOR
				)
			);
		}
		$this->get( 'default.php' );
	}
	
	public function search( $clean = array() )
	{
		if ( count( $clean ) <= 0 && isset( $_POST ) && count( $_POST ) > 0 )
			$clean = $this->stripslashes_deep( $_POST );

		$results = $this->perform_search( $clean['directory'], $clean['file_extension'], $clean['s'] );
		
		$vars = array(
			's' => $clean['s'],
			'dir' => $clean['directory'],
			'ext' => $clean['file_extension'],
			'results' => $results['files'],
			'found' => $results['found_files'],
			'infected' => $results['found_infected']
		);
		
		$this->extract = array_merge( $clean, $vars );
		$this->get( 'search.php' );
	}
	
	public function perform_search( $dir, $ext, $search, $replace = false )
	{
		$return = array(
			'files' => array(),
			'found_files' => 0,
			'found_infected' => 0
		);
		
		$pattern = rtrim( $dir, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR . '*';
		foreach ( glob( $pattern ) as $file )
		{
			// don't mess with me
			if ( dirname( __FILE__ ) == dirname( $file ) || $file == __FILE__ )
				continue;

			// recursively search subdirectories
			if ( is_dir( $file ) )
			{
				$result = $this->perform_search( $file, $ext, $search, $replace );
				$return['files'] = array_merge( $return['files'], $result['files'] );
				$return['found_files'] += $result['found_files'];
				$return['found_infected'] += $result['found_infected'];
				continue;
			}
			
			// search files
			if ( strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) == strtolower( $ext ) )
			{
				$return['found_files']++;
				$contents = file_get_contents( $file );
				$search_pattern = '/(' . preg_quote( $search, '/' ) . ')/mi';
				if ( preg_match( $search_pattern, $contents ) )
				{				
					$return['files'][] = $file;
					$return['found_infected']++;
				}
			}
		}		
		return $return;
	}

	public function do_clean()
	{
		$this->extract = array();
		if ( isset( $_POST['files'] ) && is_array( $_POST['files'] ) && count( $_POST['files'] ) > 0 )
		{
			$s = $this->stripslashes_deep( $_POST['s'] );
			$files = $this->stripslashes_deep( $_POST['files'] );
			foreach ( $files as $file )
			{
				$contents = file_get_contents( $file );
				file_put_contents( $file, $this->clean( $contents, $s ) );
			}
			$this->extract['files'] = $files;
		}
		$this->get( 'replaced.php' );
	}
	
	public function preview()
	{
		if ( isset( $_POST['file'] ) && file_exists( $_POST['file'] ) )
			$contents = file_get_contents( $_POST['file'] );
		header( 'Content-Type: text/html' );
		
		$s = isset( $_POST['s'] ) ? $this->stripslashes_deep( $_POST['s'] ) : '';
		if ( $s )
		{
			if ( isset( $_POST['clean'] ) && $_POST['clean'] )
				$contents = $this->clean( $contents, $s );
			else
				$contents = preg_replace( $this->get_search_pattern( $s ), '[[[[[\\1]]]]]', $contents );
		}
		
		$this->contents = $contents;
		$this->get( 'preview.php' );
	}
	
	public function clean( $contents, $s )
	{
		$search_pattern = $this->get_search_pattern( $s );
		return preg_replace( $search_pattern, '', $contents );
	}
	
	public function get_search_pattern( $s )
	{
		return '/(' . preg_quote( $s, '/' ) . ')/';
	}
	
}