import React, { useState, useEffect } from 'react'

import {
	LoanAmoSchedule,
	LoanAmoScheduleWrapper
} from './LAStyles'

import {formatMoney} from '../lib/helpers'

const LASchedule = ({amoSchedule}) => {
	return (<LoanAmoScheduleWrapper>
		<h4>Amortization Schedule</h4>

		<LoanAmoSchedule>
			<table className={"ima-rent-roll-table ima-table"}>
				<thead>
					<tr className={"ima-table-row"}>
						<th>Month</th>
						<th>Payment</th>
						<th>Interest</th>
						<th>Principal</th>
						<th>New Balance</th>
					</tr>
				</thead>

				<tbody>
					{amoSchedule
						&& 0 < amoSchedule.length
						&& amoSchedule.map((period, idx) => {

							return <tr
								key={idx}
								className={"ima-table-row"}>

								<td className={"align-center"}>
									{(idx + 1)}
								</td>
								<td className={"align-center"}>
									${formatMoney(period.payment)}
								</td>
								<td className={"align-center"}>
									${formatMoney(period.interest)}
								</td>
								<td className={"align-center"}>
									${formatMoney(period.principal)}
								</td>
								<td className={"align-center"}>
									${formatMoney(period.newBalance)}
								</td>

							</tr>
						})}
				</tbody>
			</table>
		</LoanAmoSchedule>
	</LoanAmoScheduleWrapper>)
}

export default LASchedule
