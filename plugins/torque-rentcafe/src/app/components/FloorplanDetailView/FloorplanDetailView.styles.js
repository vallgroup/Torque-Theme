import styled from "styled-components";

// main container
export const FloorplanDetailContainer = styled.div.attrs(props => ({
  className: 'FloorplanDetailContainer'
}))`
  width: 100%;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
`;

export const BackToFloorplans = styled.a.attrs(props => ({
  className: 'BackToFloorplans'
}))`
  flex: 1 1 100%;
  margin: 0 0 20px 10px;
`;

export const BackIcon = styled.span.attrs(props => ({
  className: 'BackIcon'
}))`
  font-size: 1.8em;
  padding-right: 10px;
`;

// content container
export const FloorplanContentContainer = styled.div.attrs(props => ({
  className: 'FloorplanContentContainer'
}))`
  flex: 0 0 40%;
`;

export const TitleContainer = styled.h1.attrs(props => ({
  className: 'TitleContainer'
}))`
  width: 100%;
  height: auto;
`;

export const DetailsContainer = styled.div.attrs(props => ({
  className: 'DetailsContainer'
}))`
  width: 100%;
  height: auto;

  display: flex;
  flex-wrap: wrap;

  margin-bottom: 38px;
  padding-bottom: 20px;
  border-bottom: 1px solid #ddd;
`;

export const DetailWrapper = styled.div.attrs(props => ({
  className: 'DetailWrapper'
}))`
  flex: 1 1 100%;
  display: flex;

  margin: 0 0 20px 10px;
`;

export const DetailName = styled.div.attrs(props => ({
  className: 'DetailName'
}))`
  flex: 0 0 30%;

  font-weight: bold;

  margin-right: 6px;
`;

export const DetailValue = styled.div.attrs(props => ({
  className: 'DetailValue'
}))`
  flex: 1;
  text-transform: capitalize;
`;

export const FloorplanButtonsContainer = styled.div.attrs(props => ({
  className: 'FloorplanButtonsContainer'
}))`
  width: 100%;
  height: auto;

  display: flex;
  flex-wrap: wrap;
`;

export const FloorplanButton = styled.a.attrs(props => ({
  className: 'FloorplanButton'
}))`

`;

// image container
export const FloorplanImageContainer = styled.div.attrs(props => ({
  className: 'FloorplanImageContainer'
}))`
  flex: 0 0 58%;
  text-align: right;
`;

export const FloorplanImage = styled.img.attrs(props => ({
  className: 'FloorplanImage'
}))`
  width: auto;
  height: auto;
  max-height: 500px;
  max-width: 100%;
`;

// thumbnail container
export const FloorplanThumbnailContainer = styled.div.attrs(props => ({
  className: 'FloorplanThumbnailContainer'
}))`
  display: flex;
  flex-direction: row-reverse;
  width: 100%;
`;

export const FloorplanThumbnail = styled.img.attrs(props => ({
  className: 'FloorplanThumbnail'
}))`
  width: auto;
  height: 150px ;
  margin: 1%;
  border: 1px solid ${props => props.active
    ? `#086762`
    : `transparent`}
`;