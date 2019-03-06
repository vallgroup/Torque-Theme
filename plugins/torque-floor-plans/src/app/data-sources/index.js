import axios from "axios";
import Entrata from "./entrata";

export default class DataSource {
  constructor({ site, dataSource }) {
    this.site = site;
    this.dataSource = dataSource;
  }

  getFloorPlans = async () => {
    switch (this.dataSource) {
      case "entrata":
        return [];

      default: {
        const floorPlans = await this.getDefaultFloorPlans();
        return floorPlans;
      }
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
