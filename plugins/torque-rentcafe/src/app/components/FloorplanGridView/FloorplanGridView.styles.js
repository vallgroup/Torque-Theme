import styled from "styled-components";

export const FloorplanContainer = styled.div.attrs(props => ({
  className: 'FloorplanContainer'
}))`
  position: relative;
  flex: 1 1 100%;

  @media only screen and (min-width: 767px) {
    flex: 0 0 50%;
  }
  @media only screen and (min-width: 1024px) {
    flex: 0 0 33.33%;
  }
`;

export const LightboxImageToggle = styled.img.attrs(props => ({
  className: 'LightboxImageToggle'
}))`
  position: absolute;
  right: 10px;
  top: 10px;
  width: 20px;
  height: 20px;
  cursor: pointer;
`;

export const LightboxWrapperAnchor = styled.a.attrs(props => ({
  className: 'LightboxWrapperAnchor'
}))`
  text-decoration: none;
  cursor: pointer;
`;

export const FloorplanImageContainer = styled.div.attrs(props => ({
  className: 'FloorplanImageContainer'
}))`
  width: 100%;
  height: auto;
  text-align: center;
`;

export const FloorplanImage = styled.img.attrs(props => ({
  className: 'FloorplanImage'
}))`
  width: auto;
  height: auto;
  max-width: 100%;
  max-height: 300px;
`;

export const FloorplanContentContainer = styled.div.attrs(props => ({
  className: 'FloorplanContentContainer'
}))`
  width: 100%;
  box-sizing: border-box;
  padding: 1.2em;
`;

export const TitleContainer = styled.h3.attrs(props => ({
  className: 'TitleContainer'
}))`
  width: 100%;
  height: auto;
  margin-bottom: 10px;
`;

export const DetailsContainer = styled.div.attrs(props => ({
  className: 'DetailsContainer'
}))`
  width: 100%;
  height: auto;

  display: flex;
  flex-wrap: wrap;
`;

export const DetailWrapper = styled.div.attrs(props => ({
  className: 'DetailWrapper'
}))`
  flex: 1 1 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  align-items: center;
  margin-bottom: 6px;
`;

export const DetailName = styled.div.attrs(props => ({
  className: 'DetailName'
}))`
  font-weight: bold;
  margin-right: 18px;
`;

export const DetailIcon = styled.img.attrs(props => ({
  className: 'DetailIcon'
}))`
  width: 22px;
  height: auto;
  max-width: 22px;
  max-height: 22px;
`;

export const DetailValue = styled.div.attrs(props => ({
  className: 'DetailValue'
}))`
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