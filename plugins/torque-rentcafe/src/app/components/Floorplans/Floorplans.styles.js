import styled from "styled-components";

export const FloorplansContainer = styled.div.attrs(props => ({
  className: 'FloorplansContainer'
}))`
  position: relative;
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;

  @media only screen and (min-width: 767px) {
    &::after {
      content: "";
      flex: 0 0 50%;
    }
  }
  @media only screen and (min-width: 1024px) {
    &::after {
      content: "";
      flex: 0 0 32.33%;
    }
  }
`;

export const FloorplansDisclaimerContainer = styled.div.attrs(props => ({
  className: 'FloorplanDisclaimer'
}))`
  max-width: 600px;
  margin: -3vw auto 6vw;
  color: #b4b4b7;
  text-align: center;
  font-size: 14px;
`;

export const SiteMapLightboxWrapperAnchor = styled.a.attrs(props => ({
  className: 'SiteMapLightboxWrapperAnchor',
  show: props.show || false
}))`
  position: absolute;
  top: 0;
  left: 0;
  overflow: hidden;
  width: 100%;
  height: 100%;
  max-height: ${props => props.show
    ? `100%`
    : `0`};
  text-decoration: none;
  cursor: pointer;
  background-color: rgba(255,255,255,0.3);
  transition: 0.5s;
`;

export const SiteMapImage = styled.img.attrs(props => ({
  className: 'SiteMapImage',
  show: props.show || false
}))`
  position: absolute;
  overflow: hidden;
  width: 100%;
  height: auto;
  opacity: ${props => props.show
    ? `1`
    : `0`};
  text-align: center;
  transition: 0.5s;
`;