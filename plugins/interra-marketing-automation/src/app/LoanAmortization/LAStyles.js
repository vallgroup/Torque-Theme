import styled from 'styled-components'

export const LoanAmoForm = styled.div.attrs(
	props => ({
		className: `LoanAmoForm`,
	})
)`
	display: block;
	margin: 2em 0;
	float: left;
	width: 35%;
	box-sizing: border-box;
`

export const LoanAmoFieldRow = styled.div.attrs(
	props => ({
		className: `LoanAmoFieldRow`,
	})
)`
	display: block;
	margin: 1em 0;
`

export const LoanAmoInputField = styled.input.attrs(
	props => ({
		className: `LoanAmoInputField`,
	})
)`
	padding: 0.5em;
	border: 1px solid #ccc;
	border-radius: 0.375em;

	padding: 0 0.5em;
  border: 0;
  border-bottom: 1px solid #ccc;
  border-radius: 0;
  text-indent: 0;
  text-align: right;
`

export const LoanAmoPrependField = styled.div.attrs(
	props => ({
		className: `LoanAmoPrependField`,
	})
)`
	position: absolute;
	top: 0;
	left: 0;
	width: 2em;
	box-sizing: border-box;
	text-align: right;
	padding: 0.5em;
`

export const LoanAmoAppendField = styled.div.attrs(
	props => ({
		className: `LoanAmoAppendField`,
	})
)`
	position: absolute;
	top: 0;
	right: 0;
	width: 2em;
	box-sizing: border-box;
	text-align: left;
	padding: 0.5em;
`

export const LoanAmoSelectFieldContainer = styled.div.attrs(
	props => ({
		className: `LoanAmoSelectFieldContainer`,
	})
)`
	position: relative;
	display: block;

	&:after {
		content: '\f107';
		display: block;
		font-family: 'FontAwesome';
		position: absolute;
		top: 0.5em;
		right: 1em;
	}
`

export const LoanAmoSelectField = styled.select.attrs(
	props => ({
		className: `LoanAmoSelectField`,
	})
)`
	position: relative;
	padding: 0.5em;
	border: 1px solid #ccc;
	border-radius: 0.375em;
	width: 100%;
	background: #fff;
	appearance: none;
	-webki-appearance: none;
	color: #686a6c;
	padding: 0.5em 0.5em;

	&:after {
		content: '\f107';
		display: block;
		font-family: 'FontAwesome';
		position: absolute;
		top: 0.5em;
		right: 1em;
		pointer-events: none;
	}
`

export const LoanAmoFieldName = styled.div.attrs(
	props => ({
		className: `LoanAmoFieldName`,
	})
)``

export const LoanAmoFieldWrapper = styled.div.attrs(
	props => ({
		className: `LoanAmoFieldWrapper`,
	})
)`
	position: relative;
	padding: 0 2em;
	box-sizing: border-box;
`

export const LoanAmoFormResults = styled.div.attrs(
	props => ({
		className: `LoanAmoFormResults`,
	})
)`
	// text-align: center;
	margin: 2em 0;
	max-width: 570px;
	h5 {
		color: #636363;
	}
`

export const LoanAmoContainer = styled.div.attrs(
	props => ({
		className: `LoanAmoContainer`,
	})
)`
	&:after {
		content: '';
		display: table;
		clear: both;
	}
`

export const LoanAmoScheduleWrapper = styled.div.attrs(
	props => ({
		className: `LoanAmoScheduleWrapper`,
	})
)`
	width: 60%;
	float: right;
	margin: 2em 0;
`

export const LoanAmoSchedule = styled.div.attrs(
	props => ({
		className: `LoanAmoSchedule`,
	})
)`
	overflow: auto;
	max-height: 500px;

::-webkit-scrollbar {
  height:5px;
  width:5px;
}

::-webkit-scrollbar-track {
    -webkit-box-shadow: transparent;
  background: rgba(104,106,108,.25);
  border-right:0px solid black;
}

::-webkit-scrollbar-thumb {
  background-color: #78b855;
  outline: 2px solid #78b855;
  border-radius: 0;
}
::-webkit-scrollbar-corner {
  background-color: transparent;
  border-right: 0px !important;
}

::-webkit-scrollbar-track:horizontal {
  background: transparent;
  border-left: 0px;
}

	table {
		min-width: 1000px;
	}
`
