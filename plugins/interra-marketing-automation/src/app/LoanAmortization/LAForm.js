import React, { useState, useEffect } from 'react'
import MortgageCalculator from "mortgage-calculator-react";

import {
	LoanAmoForm,
	LoanAmoFieldRow,
	LoanAmoFieldWrapper,
	LoanAmoInputField,
	LoanAmoSelectField,
	LoanAmoPrependField,
	LoanAmoAppendField,
	LoanAmoFormResults,
	LoanAmoSchedule,
	LoanAmoSelectFieldContainer
} from './LAStyles'

import {formatMoney} from '../lib/helpers'

const LAForm = ({loanAmo, updateAmoTable}) => {
	//
	const [loading       , setLoading]       = useState(true)
	const [term          , setTerm]          = useState(loanAmo.term)
	const [downPayment   , setDownPayment]   = useState(loanAmo.down_payment)
	const [propertyValue , setPropertyValue] = useState(loanAmo.property_value)
	const [interestRate  , setInterestRate]  = useState(loanAmo.interest_rate)
	const [monthlyPmt    , setMonthlyPmt]    = useState(null)
	const [amoSchedule   , setAmoSchedule]   = useState([])


	const updateAmo = () => calcMortgagePmt();

	const calcMortgagePmt = () => {

		const principal   = propertyValue - (propertyValue * (downPayment / 100))
		const rate        = interestRate * 0.01;
		const monthlyRate = rate/12;
		const periods     = (term * 12);

    // console.log({ principal, rate, monthlyRate, periods })

		const factor      = Math.pow(monthlyRate + 1, periods);
		const numerator   = monthlyRate * factor;
		const denominator = factor - 1;
		const quotient    = numerator/denominator;
		const payment     = principal * quotient;

    // build our pament object
		const PI          = payment.toFixed(2);                              // Principal & Interest
		const I           = Math.round((monthlyRate * principal).toFixed(2)) // Interest only
		const P           = (PI - I).toFixed(2)                              // Principal only

    setMonthlyPmt({
			PI,
			I,
			P,
    })
  }

  const updateAmoSchedule = () => {
  	if (!monthlyPmt) return;

  	const rate        = interestRate * 0.01;

  	let balance = propertyValue - (propertyValue * (downPayment / 100))
		const monthlyRate = rate/12;

  	// const newPrincipal = (initialPrincipal - monthlyPmt.P)

  	let __amoSchd = []
  	for (var i = 0; i < (term * 12); i++) {
  		const payment = monthlyPmt.PI

  		const interest = Math.round((monthlyRate * balance).toFixed(2))
  		let principal = (payment - interest).toFixed(2)
  		let newBalance = (balance - principal).toFixed(2)

  		const __pmtPeriod = {
  			payment,
  			interest,
  			principal,
  			balance,
  			newBalance
  		}

  		__amoSchd = [...__amoSchd, __pmtPeriod]

  		balance = newBalance
  	}

  	updateAmoTable(__amoSchd)

  }


	useEffect( updateAmo , [term, downPayment, propertyValue, interestRate])

	useEffect(() => {
		updateAmoSchedule()

		return () => {}
	}, [monthlyPmt])

	if (!loanAmo) {
		return 'Loading...'
	}

	return (<LoanAmoForm>

		<LoanAmoFieldRow>
			<label htmlFor={'term'}>
				<div className={"pwp-inline"}>
					<div className={"span7"}>
						Term:
					</div>
					<LoanAmoFieldWrapper className={"span5"}>
						<LoanAmoSelectFieldContainer>
							<LoanAmoSelectField
								id={'term'}
								value={term}
								onChange={e => setTerm(e.target.value)}
							>
								<option value={15}>15 Years</option>
								<option value={30}>30 Years</option>
							</LoanAmoSelectField>
						</LoanAmoSelectFieldContainer>
					</LoanAmoFieldWrapper>
				</div>
			</label>
		</LoanAmoFieldRow>

		<LoanAmoFieldRow>
			<label htmlFor={'down-payment'}>
				<div className={"pwp-inline"}>
					<div className={"span7"}>
						Down Payment:
					</div>
					<LoanAmoFieldWrapper className={"span5"}>
						<LoanAmoInputField
							id={'down-payment'}
							type={'number'}
							value={downPayment}
							onChange={e => setDownPayment(e.target.value)}
						/>
						<LoanAmoAppendField
							className={'pwp-inline-block pwp-vertical-align-middle'}>
							%
						</LoanAmoAppendField>
					</LoanAmoFieldWrapper>
				</div>
			</label>
		</LoanAmoFieldRow>

		<LoanAmoFieldRow>
			<label htmlFor={'property-value'}>
				<div className={"pwp-inline"}>
					<div className={"span7"}>
						Property Value:
					</div>
					<LoanAmoFieldWrapper className={"span5"}>
						<LoanAmoPrependField
							className={'pwp-inline-block pwp-vertical-align-middle'}>
							$
						</LoanAmoPrependField>
						<LoanAmoInputField
							id={'property-value'}
							type={'text'}
							value={formatMoney(propertyValue)}
							onChange={e => setPropertyValue(e.target.value.replace(/[^0-9.,]/, ''))}
						/>
					</LoanAmoFieldWrapper>
				</div>
			</label>
		</LoanAmoFieldRow>

		<LoanAmoFieldRow>
			<label htmlFor={'interest-rate'}>
				<div className={"pwp-inline"}>
					<div className={"span7"}>
						Interest Rate:
					</div>
					<LoanAmoFieldWrapper className={"span5"}>
						<LoanAmoInputField
							id={'interest-rate'}
							type={'number'}
							value={interestRate}
							onChange={e => setInterestRate(e.target.value)}
						/>
						<LoanAmoAppendField
							className={'pwp-inline-block pwp-vertical-align-middle'}>
							%
						</LoanAmoAppendField>
					</LoanAmoFieldWrapper>
				</div>
			</label>
		</LoanAmoFieldRow>

		{monthlyPmt
			&& <LoanAmoFieldRow>
				<LoanAmoFormResults>
					<div className={`pwp-inline`}>
						<div className={`span7`}>
							<h5>Loan Amount:</h5>
						</div>
						<div className={`span5 pwp-align-left`} style={{paddingLeft: '36px'}}>
							<h5>${formatMoney(propertyValue - (propertyValue * (downPayment / 100)))}</h5>
						</div>
					</div>

					<div className={`pwp-inline`}>
						<div className={`span7`}>
							<h5>Monthly Payment:</h5>
						</div>
						<div className={`span5 pwp-align-left`} style={{paddingLeft: '36px'}}>
							<h5>${formatMoney(monthlyPmt.PI)}</h5>
						</div>
					</div>
				</LoanAmoFormResults>
			</LoanAmoFieldRow>}

	</LoanAmoForm>)
}

export default LAForm