import axios from "axios";
import Entrata from "./entrata";

// we only want to initialise this once
let entrata = null;

export default class DataSource {
  constructor({ site, dataSource, dataSourceProps }) {
    this.site = site;
    this.dataSource = dataSource;
    this.dataSourceProps = dataSourceProps;
  }

  getFloorPlans = async () => {
    switch (this.dataSource) {
      case "entrata": {
        entrata =
          entrata ||
          new Entrata({
            site,
            propertyID: this.dataSourceProps?.entrata?.propertyID
          });
        await entrata.init();
        return await entrata.getFloorPlans();
      }

      default:
        return await this.getDefaultFloorPlans();
    }
  };

  getDefaultFloorPlans = async () => {
    const url = `${this.site}/wp-json/floor-plans/v1/floor-plans/`;
    const response = await axios.get(url);

    if (response?.data?.success) {
      return response.data.floor_plans;
    } else {
      throw "Error getting default floor plans";
    }
  };
}
