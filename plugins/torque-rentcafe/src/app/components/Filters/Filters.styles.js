import styled from "styled-components";

export const FiltersContainer = styled.div.attrs(props => ({
  className: 'FiltersContainer'
}))`
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: flex-start;
  box-sizing: border-box;
  padding: 0.5em 0;
  border-top: 4px solid #96855e;
  border-bottom: 4px solid #96855e;
`;

export const FilterContainer = styled.div.attrs(props => ({
  className: 'FilterContainer'
}))`
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: flex-start;
  box-sizing: border-box;
  padding: 10px 20px 10px 0;
`;

export const FilterTitle = styled.div.attrs(props => ({
  className: 'FilterTitle'
}))`
  // flex: 1 1 100%;
  box-sizing: border-box;
  font-family: TradeGothicLTStd-Ext;
  font-size: 20px;
  font-weight: bold;
  font-stretch: normal;
  font-style: normal;
  line-height: 1.4;
  letter-spacing: 2px;
  text-align: left;
  color: #96855e;
  text-transform: uppercase;
  padding: 0 3.8em 0 2em;
}
`;

export const FilterButtonsContainer = styled.div.attrs(props => ({
  className: 'FilterButtonsContainer'
}))`
  // flex: 1 1 100%;
  box-sizing: border-box;
  padding: 10px 10px 5px;
  display: flex;
  flex-wrap: no-wrap;
  justify-content: space-between;
`;

export const FilterButton = styled.button.attrs(props => ({
  className: 'FilterButton'
}))`
  flex: auto;
  box-sizing: border-box;
  padding: 0.2em 0.5em;
  font-family: Cochin;
  font-size: 20px;
  font-weight: bold;
  font-stretch: normal;
  font-style: normal;
  line-height: 1.25;
  text-transform: capitalize;
  border: 0;
  margin: 0 2.5em 5px 0;
  max-width: 135px;

  &:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  ${props => props.active
    ? `color: #FFF;
      background: transparent;`
    : `color: #96855e;
      background: transparent;`}
`;

export const FilterRangeContainer = styled.div.attrs(props => ({
  className: 'FilterRangeContainer'
}))`
  flex: 1 1 100%;
  box-sizing: border-box;
  padding: 10px;
  display: flex;
  flex-wrap: wrap;
`;

export const FilterRange = styled.input.attrs(props => ({
  className: 'FilterRange'
}))`
  flex: 1 1 100%;
  box-sizing: border-box;
  padding: 0 2px;
`;

export const RangeMin = styled.div.attrs(props => ({
  className: 'RangeMin'
}))`
  flex: 0 0 50%;
  box-sizing: border-box;
  padding: 0;
  text-align: left;
  font-size: 12px;
`;

export const RangeMax = styled.div.attrs(props => ({
  className: 'RangeMax'
}))`
  flex: 0 0 50%;
  box-sizing: border-box;
  padding: 0;
  text-align: right;
  font-size: 12px;
`;

export const FiltersButtonsContainer = styled.div.attrs(props => ({
  className: 'FiltersButtonsContainer'
}))`
  width: 100%;
  box-sizing: border-box;
  padding: 2vw 6vw 6vw;
`;

export const FiltersFormButton = styled.button.attrs(props => ({
  className: 'FiltersFormButton'
}))`
  flex: auto;
  box-sizing: border-box;
  padding: 10px 25px;
  text-transform: uppercase;
  font-size: 18px;
  margin: 0 15px 0 10px;
  border: 1.5px solid;

  ${props => 'solid' === props.type
    ? `color: #FFF;
       background: #96d6ce;
       border-color: #96d6ce;`
    : `color: #96d6ce;
       background: #FFF;
       border-color: #96d6ce;`}
`;

export const SiteMapButton = styled.button.attrs(props => ({
  className: 'FilterButton SiteMapButton'
}))`
  flex: auto;
  box-sizing: border-box;
  padding: 0.2em 0.5em;
  font-family: Cochin;
  font-size: 20px;
  font-weight: bold;
  font-stretch: normal;
  font-style: normal;
  line-height: 1.25;
  text-transform: capitalize;
  border: 0;
  margin: 0 2.5em 5px 0;
  max-width: 135px;

  &:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  ${props => props.active
    ? `color: #FFF;
      background: transparent;`
    : `color: #96855e;
      background: transparent;`}
`;