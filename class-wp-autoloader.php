<?php
/**
 * Class WP Autoloader implements spl_autoload_register function according to custom WP-based naming.
 *
 * @package My_App
 */

namespace My_App;

/**
 * Class WP_Autoloader
 */
class WP_Autoloader {

	/**
	 * Relative path from root to folder where files are located.
	 *
	 * @var string
	 */
	private string $folder;

	/**
	 * WP_Autoloader constructor.
	 *
	 * @param string $folder Relative path from root to folder where classes are located.
	 */
	public function __construct( string $folder = '' ) {
		// Verify correct folder naming.
		if ( $folder && ! preg_match( '/^[a-z0-9]+?(?:(-|\/)[a-z0-9]+?)*$/', $folder ) ) {
			$this->autoloader_die(
				__( 'Folder naming is wrong in path', 'my-app' ),
				$folder
			);
		}

		// Implement spl autoload.
		$this->folder = $folder;
		spl_autoload_register( [ $this, 'wordpress_autoloader' ] );
	}

	/**
	 * Kills WordPress execution and displays HTML page with an error message.
	 *
	 * @param string $error Error text.
	 * @param string $cause Cause of the error.
	 */
	private function autoloader_die( string $error, string $cause ): void {
		wp_die(
			wp_kses_post( '<b>' . esc_html( $error ) . ':</b><br><pre>' . $cause . '</pre>' ),
			'Error - WordPress Autoloader',
			[
				'link_url'  => 'https://github.com/alexander-kozhukhovski/wordpress-autoloader#naming-convention',
				'link_text' => 'WordPress Autoloader Naming Convention',
				'code'      => 'wp_autoloader'
			]
		);
	}

	/**
	 * Custom autoloader callback.
	 *
	 * @param string $file Classname passed to spl autoload.
	 */
	public function wordpress_autoloader( string $file ): void {
		// Only autoload classes from this namespace.
		if ( false === strpos( $file, __NAMESPACE__ ) ) {
			return;
		}

		// Verify correct namespace naming.
		if ( ! preg_match( '/^[A-Z]+([a-z0-9]+)?(?:(_|\\\\)[A-Z]+([a-z0-9]+)?)*$/', $file ) ) {
			$this->autoloader_die( __( 'File has wrong naming convention', 'my-app' ), $file );
		}

		// Remove first level of namespace and replace slashes.
		$file = str_replace( [ __NAMESPACE__ . '\\', '\\' ], [ '', '/' ], $file );

		// Add root path.
		if ( $this->folder ) {
			$file = $this->folder . '/' . $file;
		}

		// Get file info.
		$spl_file  = new \SplFileInfo( $file );
		$file_name = $spl_file->getFilename();

		// Check if file is a class, a trait or an interface according adopted PSR naming convention.
		$type = 'class';
		if ( substr( $file_name, - 6 ) === '_Trait' ) {
			$file_name = substr( $file_name, 0, - 6 );
			$type      = 'trait';
		} elseif ( substr( $file_name, - 10 ) === '_Interface' ) {
			$file_name = substr( $file_name, 0, - 10 );
			$type      = 'interface';
		} else {
			// Remove abstract class prefix.
			$file_name = str_replace( 'Abstract_', '', $file_name );
		}

		// Build real file path.
		$file_path = str_replace(
			[ '_', '/' ],
			[ '-', DIRECTORY_SEPARATOR ],
			$spl_file->getPath() . '/' . $type . '-' . $file_name . '.php'
		);
		$file_path = __DIR__ . DIRECTORY_SEPARATOR . strtolower( $file_path );

		// Load class, trait or interface if exist.
		$stream_resolved = stream_resolve_include_path( $file_path );
		if ( ! $stream_resolved ) {
			$this->autoloader_die( __( 'File does not exist', 'my-app' ), $file_path );
		}

		// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		require_once $stream_resolved;
	}
}
