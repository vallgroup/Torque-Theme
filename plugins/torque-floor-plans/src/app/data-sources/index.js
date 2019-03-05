import axios from "axios";

export default class DataSource {
  constructor({ site, dataSource, dataSourceProps }) {
    this.site = site;
    this.dataSource = dataSource;
    this.dataSourceProps = dataSourceProps;
  }

  getFloorPlans = async () => {
    switch (this.dataSource) {
      case "entrata":
        return [];

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
