<?php
/**
 * Register the torque job application cpt
 *
 * This is a hidden post type that just makes it easier for us to save
 * job applications
 */
class Torque_Job_Application_CPT {

	public static $save_application_action_handle = 'torque_job_application_save';

	public static $PUBLIC_FILTER_HOOK = 'torque_careers_job_application_public';

	/**
	 * We should use this static function to add new applications to the db
	 */
	public static function save_application( string $applicant_name, array $application_data ) {
		$application = array(
		  'post_title'    => $applicant_name,
		  'post_content'  => serialize($application_data),
		  'post_status'   => 'publish',
			'post_type'			=> self::$job_applications_labels['post_type_name']
		);

		// Insert the post into the database
		$application_id = wp_insert_post( $application );

		do_action( self::$save_application_action_handle, $application_id );

		return $application_id;
	}

	/**
	 * Holds the labels needed to build the job_applications custom post type.
	 *
	 * @var array
	 */
	public static $job_applications_labels = array(
			'singular'       => 'Job Application',
			'plural'         => 'Job Applications',
			'slug'           => 'torque-job-app',
			'post_type_name' => 'torque_job_app',
	);

	/**
	 * Holds the job_applications cpt object
	 *
	 * @var Object
	 */
	protected $job_applications = null;

	/**
	 * Holds options for the job_applications custom post type
	 *
	 * @var array
	 */
	protected $job_applications_options = array(
		'public'				=> false,
		'supports'			=> array(
			'title',   // will just hold the applicant name, making it easier to search
			'editor'  // serialized array of the application data to keep it flexible
		),
		'menu_icon'				=> 'dashicons-id',
		'menu_position'		=> 20,
		// ensure that no application appears on search
		'exclude_from_search' => true,
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {

			add_action('after_setup_theme', function() {
				$this->job_applications_options['public'] = apply_filters( self::$PUBLIC_FILTER_HOOK, false );

				new PremiseCPT( self::$job_applications_labels, $this->job_applications_options );
			});
		}
	}
}

?>
