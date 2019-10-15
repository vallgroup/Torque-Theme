<?php

/**
 * Email Templates
 */
class IMA_Mailchimp_Email_Template {

	function __construct( string $tmpl, string $style, int $postID ) {
		$this->tmpl = $tmpl;
		$this->style = $style;
		$this->postID = $postID;

		$this->load_post();

		global $style;
		$style = $this->style;
	}

	public function get_template () {
		switch( $this->tmpl ) {
			case 'header':
				$_tmpl = $this->get_head_tmpl();
				$_tmpl .= $this->get_header_tmpl();
			break;

			case 'body':
				$_tmpl = $this->get_body_tmpl();
			break;

			case 'footer':
				$_tmpl = $this->get_footer_tmpl();
			break;
		}
		return str_replace( ['<','>'], ['&lt;', '&gt;'], $_tmpl );
	}

	protected function load_post() {
		global $document;
		$this->doc = get_post( $this->postID );
		$document = $this->doc;
	}

	protected function get_head_tmpl() {
		$_html = '';
		ob_start();

		load_template( Interra_Marketing_Automation_API_ROOT . 'mailchimp/templates/head.php' );

		$_html = ob_get_clean();
		return $_html . PHP_EOL;
	}

	protected function get_header_tmpl() {
		$_html = '';
		ob_start();

		load_template( Interra_Marketing_Automation_API_ROOT . 'mailchimp/templates/header.php' );

		$_html = ob_get_clean();
		return $_html . PHP_EOL;
	}

	protected function get_body_tmpl() {
		$_html = '';
		ob_start();

		load_template( Interra_Marketing_Automation_API_ROOT . 'mailchimp/templates/body.php' );

		$_html = ob_get_clean();
		return $_html . PHP_EOL;
	}

	protected function get_footer_tmpl() {
		$_html = '';
		ob_start();

		load_template( Interra_Marketing_Automation_API_ROOT . 'mailchimp/templates/footer.php' );

		$_html = ob_get_clean();
		return $_html . PHP_EOL;
	}


}

?>