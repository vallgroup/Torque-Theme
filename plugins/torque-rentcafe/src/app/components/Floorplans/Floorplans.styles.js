import styled from "styled-components";

export const FloorplansContainer = styled.div.attrs(props => ({
  className: 'FloorplansContainer'
}))`
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

export const FloorplanDisclaimer = styled.div.attrs(props => ({
  className: 'FloorplanDisclaimer'
}))`
  max-width: 600px;
  margin: -3vw auto 6vw;
  color: #b4b4b7;
  text-align: center;
  font-size: 14px;
`;