import axios from "axios";

export default class Entrata {
  constructor({ site }) {
    this.requestUrl = endpoint =>
      `${site}/wp-json/floor-plans/v1/entrata/${endpoint}`;
  }

  getUnitTypes = async () => {
    try {
      const response = await axios.get(this.requestUrl("unit-types"));

      if (!response?.data?.success) {
        throw "Error getting unit types";
      }

      return response?.data?.unit_types;
    } catch (err) {
      console.log(err);
      return [];
    }
  };

  getFloorPlans = async ({ unitTypeIds = [], startDate = false }) => {
    try {
      const params = { unit_type_ids: unitTypeIds, start_date: startDate };
      const response = await axios.get(this.requestUrl("floor-plans"), {
        params
      });

      if (!response?.data?.success) {
        throw "Error getting floor plans";
      }

      return Object.values(response?.data?.floor_plans || {});
    } catch (err) {
      console.log(err);
      return [];
    }
  };
}
