import styled from 'styled-components'

// breakpoints
const TabletMinWidth = `768px`
const DesktopMinWidth = `1024px`

const inline = `
  display: inline-block;
  vertical-align: middle;
`
const fullWidth = `
  width: 100%;
`
const introWidth = `
  width: 100%;
  max-width: 374px;
  margin-left: auto;
  margin-right: auto;
`
const textAlignCentre = `
  text-align: center;
`

export const TorqueImageGrid = styled.div`
  ${fullWidth}
  ${textAlignCentre}
`

export const ImageGridContentWrapper = styled.div`
  ${fullWidth}
`

export const ImageGridTitle = styled.h4`
  ${fullWidth}
  ${textAlignCentre}
`

export const ImageGridContent = styled.p`
  ${inline}
  ${introWidth}
  ${textAlignCentre}
  margin-top: 0;
`

export const ImageGridImageContainer = styled.div`
  ${fullWidth}
  width: 100%;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  margin-top: 2vw;
`

export const ImageGridImageWrapper = styled.div`
  ${inline}
  padding: 0 1vw 1vw;
  box-sizing: border-box;
  width: 100%;

  @media (min-width: ${TabletMinWidth}) {
    width: 50%;
  }
  @media (min-width: ${DesktopMinWidth}) {
    ${props => 
    props.imagesPerRow &&
    `
      width: calc(100% / ${props.imagesPerRow});
    `}
  }
`

export const ImageGridImageLink = styled.a`
  cursor: pointer;
  text-decoration: none;
`

export const ImageGridImage = styled.img`
  width: 100%;
  height: auto;
`