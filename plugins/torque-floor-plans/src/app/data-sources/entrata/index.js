import axios from "axios";

export default class Entrata {
  constructor({ site }) {
    this.requestUrl = endpoint =>
      `${site}/wp-json/floor-plans/v1/entrata/${endpoint}`;

    this.unitTypes = [];
    this.availableUnits = [];
    this.floorPlans = [];
  }

  init = async () => !this.property && (await this.updateUnitTypes());

  updateUnitTypes = async () => {
    try {
      const response = await axios.get(this.requestUrl("unit-types"));

      if (!response?.data?.success) {
        throw "Error getting unit types";
      }

      this.unitTypes = response?.data?.unit_types;
      console.log(this.unitTypes);
    } catch (err) {
      console.log(err);
      this.unitTypes = [];
    }
  };

  getFloorPlans = () => {
    return [];
  };
}
