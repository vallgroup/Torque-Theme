import axios from "axios";

export default class Entrata {
  constructor(propertyID) {
    this.propertyID = propertyID;

    this.requestUrl = url => `https://lincolnapts.entrata.com/api/v1/${url}`;
    this.auth = {
      username: "torque_api@lincolnapts",
      password: "Torqueapi1172019$"
    };
    this.requestData = method => ({
      auth: {
        type: "basic"
      },
      requestId: "15",
      method
    });

    this.property = false;
    this.units = [];
    this.availableUnits = [];
    this.floorPlans = [];
  }

  init = async () => !this.property && (await this.getProperty());

  getProperty = async () => {
    /*
    try {
      const response = await fetch(this.requestUrl("properties"), {
        method: "get",
        data: this.requestData({
          name: "getProperties"
        }),
        headers: {
          "Content-Type": "application/json",
          Authorization:
            "Basic dG9ycXVlX2FwaUBsaW5jb2xuYXB0czpUb3JxdWVhcGkxMTcyMDE5JA=="
        },
        mode: "no-cors",
        credentials: "include"
      });
      console.log(response);
    } catch (err) {
      console.log(err);
    }
    */

    return {
      PropertyID: 673841,
      MarketingName: "ELEVEN33",
      PropertyLookupCode: "20440",
      Type: "Apartment",
      General_ID: "20440",
      YearBuilt: "2018",
      ShortDescription:
        "Nothing in Oak Park is standard, and that includes Eleven33. We're not just a chic and unique living space&mdash;we're the\r\nkind of place people take day trips to see. Isn't that where you'd like to be?",
      LongDescription:
        "It's More Than a Home&mdash;It's a Destination. Oak Park is a city of originals, one where Eleven33 fits right in by standing\r\nout. It's a development with its own vibe, a place where people go to live a life less ordinary. Its design is eclectic yet chic,\r\nand its luxuries are second to none. It's the good life&mdash;Oak Park style. With everything from studios to 3-bedrooms, each\r\ndecked out in our signature design, you're sure to find a home that fits like a glove.",
      webSite: "http://eleven33chicago.com",
      Address: {
        "@attributes": {
          AddressType: "property"
        },
        Address: "1133 SOUTH BLVD",
        City: "OAK PARK",
        State: "IL",
        PostalCode: "60302",
        Country: "US",
        Email: "eleven33@lincolnapts.com"
      },
      PostMonths: {
        ArPostMonth: "12/2018",
        ApPostMonth: "12/2018",
        GlPostMonth: "12/2018"
      },
      PropertyHours: {
        OfficeHours: {
          OfficeHour: [
            {
              Day: "Monday",
              AvailabilityType: "Open",
              OpenTime: "9:00 AM",
              CloseTime: "6:00 PM"
            },
            {
              Day: "Tuesday",
              AvailabilityType: "Open",
              OpenTime: "9:00 AM",
              CloseTime: "6:00 PM"
            },
            {
              Day: "Wednesday",
              AvailabilityType: "Open",
              OpenTime: "9:00 AM",
              CloseTime: "6:00 PM"
            },
            {
              Day: "Thursday",
              AvailabilityType: "Open",
              OpenTime: "9:00 AM",
              CloseTime: "6:00 PM"
            },
            {
              Day: "Friday",
              AvailabilityType: "Open",
              OpenTime: "9:00 AM",
              CloseTime: "6:00 PM"
            },
            {
              Day: "Saturday",
              AvailabilityType: "Open",
              OpenTime: "10:00 AM",
              CloseTime: "5:00 PM"
            }
          ]
        }
      },
      IsDisabled: 0,
      IsFeaturedProperty: 0,
      SpaceOptions: {
        SpaceOption: [
          {
            Id: "1",
            Name: "Conventional"
          }
        ]
      }
    };
  };

  getFloorPlans = () => {
    return [];
  };
}
