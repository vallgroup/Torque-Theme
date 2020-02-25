import styled from "styled-components";

export const FloorplanContainer = styled.div`
  flex: 1 1 100%;

  @media only screen and (min-width: 767px) {
    flex: 0 0 50%;
  }
  @media only screen and (min-width: 1024px) {
    flex: 0 0 33.33%;
  }
`;

export const FloorplanImage = styled.img`
  width: 100%;
  height: auto;
`;

export const FloorplanContentContainer = styled.div`
  width: 100%;
  box-sizing: border-box;
  padding: 1.2em;
`;

export const TitleContainer = styled.h3`
  width: 100%;
  height: auto;
`;

export const DetailsContainer = styled.div`
  width: 100%;
  height: auto;

  display: flex;
  flex-wrap: wrap;
`;

export const DetailWrapper = styled.div`
  flex: 1 1 100%;

  display: flex;

  @media only screen and (min-width: 767px) {
    flex: 0 0 50%;
  }
`;

export const DetailName = styled.div`
  font-weight: bold;
  margin-right: 6px;
`;

export const DetailValue = styled.div`
`;

export const FloorplanButtonsContainer = styled.div`
  width: 100%;
  height: auto;

  display: flex;
  flex-wrap: wrap;
`;

export const FloorplanButton = styled.a`

`;