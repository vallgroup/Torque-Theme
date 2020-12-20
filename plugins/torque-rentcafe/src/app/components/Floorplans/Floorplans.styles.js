import styled from "styled-components";

export const FloorplansContainer = styled.div.attrs(props => ({
  className: 'FloorplansContainer',
  show: props.show
}))`
  position: relative;
  width: 100%;
  display: ${props => props.show
    ? `flex`
    : `none`};
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

export const SiteMapImageAnchor = styled.a.attrs(props => ({
  className: 'SiteMapImageAnchor',
  show: props.show || false
}))`
  display: ${props => props.show
    ? `block`
    : `none`};
  text-decoration: none;
  cursor: pointer;
`;

export const SiteMapImage = styled.img.attrs(props => ({
  className: 'SiteMapImage',
  show: props.show || false
}))`
  width: 100%;
  height: auto;
  transition: 0.5s;
  opacity: ${props => props.show
    ? `1`
    : `0`};
`;