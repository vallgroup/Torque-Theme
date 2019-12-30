<?php

/**
 * Email Templates
 */
class IMA_Mailchimp_Email_Template {

	protected $doc = null;

	protected $postID = 0;

	protected $templates = array();

	function __construct( int $postID, array $templates ) {

		if ( ! $postID || 0 === $postID ) {
			return false;
		}

		$this->postID = $postID;
		$this->templates = $templates;

		if ( ! isset( $this->templates['header'] ) ) {
			$this->templates['header'] = 'style-1';
		}

		if ( ! isset( $this->templates['body'] ) ) {
			$this->templates['body'] = 'style-1';
		}

		if ( ! isset( $this->templates['footer'] ) ) {
			$this->templates['footer'] = 'style-1';
		}

		$this->load_post();
	}

	public function get_template () {
		global $post_id, $email_templates, $document;

		$document = $this->doc;
		$post_id = $this->postID;
		$email_templates = $this->templates;

		$_tmpl = '';
		ob_start();

		load_template( Interra_Marketing_Automation_API_ROOT . 'mailchimp/templates/dynamic-email.php' );

		$_tmpl = ob_get_clean();

		return str_replace( ['<','>'], ['&lt;', '&gt;'], $_tmpl );
	}

	protected function load_post() {
		$this->doc = get_post( $this->postID );
	}
}

?>
