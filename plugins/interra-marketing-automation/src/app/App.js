import React from 'react'

import LoanAmortization from './LoanAmortization/LoanAmortization'

// props
//
// site: string

const App = ({module, options}) => {

	if (!module) {
		return <div>Missing module args.</div>
	}

	if ('loanAmortization' === module) {
		return <LoanAmortization docID={options} />
	}
}

export default App
