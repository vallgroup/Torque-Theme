import React, { memo } from "React";
import Filters from "..";
import { useACFSelectChoices } from "../../hooks";

const TabsACF = ({ 
  site,
  value,
  onChange,
  args,
  galleryID,
  hideFilters,
  iframeOptions
}) => {
  if (typeof args !== "string") {
    console.warn(
      `TabsACF: expected args to be an acf select field id but got ${args}`
    );
    return null;
  }

  const choices = useACFSelectChoices(site, args, galleryID);

  // hijack the Filters component to use its' markup.. we just have to change the choices to fit
  const filterOptions = Object.keys(choices).map(choiceKey => ({
    term_id: choiceKey,
    name: choices[choiceKey]
  }));

  return (
    <Filters
      className="torque-acf-tabs-filters"
      terms={filterOptions}
      activeTerm={value}
      updateActiveTerm={onChange}
      hideFilters={hideFilters}
      iframeOptions={iframeOptions}
    />
  );
};

export default memo(TabsACF);
