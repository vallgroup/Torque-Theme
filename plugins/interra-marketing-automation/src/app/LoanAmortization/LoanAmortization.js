import React, { useState, useEffect } from 'react'

import {getLoanAmo} from '../api/loan_amo_client'

import LAForm from './LAForm'
import LASchedule from './LASchedule'

const LoanAmortization = ({docID}) => {

	const [loading, setLoading] = useState(true)
	const [loanAmo, setLoanAmo] = useState(null)
	const [amoSchedule   , setAmoSchedule]   = useState([])

	const getAmoDets = async () => {
		const response = await getLoanAmo(docID)

		if (response.success) {
			setLoanAmo(response.loan_amo)
			setLoading(false)
		}
	}

	useEffect(() => {
		getAmoDets()
	}, [])

	if (!loanAmo) {
		return 'Loading...'
	}

	const {
		term,
		down_payment,
		property_value,
		interest_rate,
	} = loanAmo

	return (<div>
		<LAForm
			loanAmo={loanAmo}
			updateAmoTable={schd => setAmoSchedule(schd)}
		/>
		<LASchedule amoSchedule={amoSchedule} />
	</div>)
}

export default LoanAmortization