import { createContext } from "react";

const InfoBoxContext = createContext({
  openInfoBox: false,
  setOpenInfoBox: (id) => {}
});

export default InfoBoxContext;
