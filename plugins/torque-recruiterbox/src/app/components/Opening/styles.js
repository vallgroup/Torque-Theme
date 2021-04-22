import styled, { css, keyframes } from 'styled-components'

const spinner = keyframes`
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
`

const animation = () =>
  css`
    ${spinner} 0.8s linear infinite;
  `

export const Spinner = styled.img`
  animation: ${animation};
  margin: auto auto auto 20px;
`