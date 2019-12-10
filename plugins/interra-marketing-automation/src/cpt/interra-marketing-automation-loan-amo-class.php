<?php

/**
 *
 */
class Interra_Marketing_Automation_Loan_Amo {

	public $property_value = 0;

	public $down_payment = 0;

	public $interest_rate = 0;

	public $term = 0;

	public $morgage_payment = 0;

	public function __construct() {
		$this->property_value = floatval( get_field( 'property_value' ) );

		$this->get_load_amo_data();
	}

	private function get_load_amo_data() {
		$this->down_payment = floatval( get_field( 'down_payment' ) );
		$this->interest_rate = (float) get_field( 'interest_rate' );
		$term_array = get_field( 'term' );
		$this->term = (int) $term_array['value'];
		$this->morgage_payment = $this->morgage_payment();
	}

	protected function morgage_payment() {
		$principal = $this->property_value - ( $this->property_value * ( $this->down_payment / 100 ) );
		$rate        = (float) ($this->interest_rate * 0.01);
		$monthly_rate = $rate / 12;
		$periods     = ( $this->term * 12 );

    // console.log({ principal, rate, monthlyRate, periods })

		$factor      = pow( $monthly_rate + 1, $periods );
		$numerator   = $monthly_rate * $factor;
		$denominator = $factor - 1;
		$quotient    = $numerator / $denominator;
		$payment     = floatval($principal * $quotient);

		// build our pament object
		$principal_interest = round( $payment, 2 );
		$interest = round( ( $monthly_rate * $principal ), 2 );
		$principal = (float) ( $principal_interest - $interest );

		return [
			'principal_interest' 	=> $principal_interest,
			'interest' 						=> $interest,
			'principal' 					=> $principal
		];
	}
}

?>
