//@flow
import axios from 'axios'
import api from '../index'
// import BoxAppValidation from '../axios/validations'

class ConvertKitAPI {
  static apiKey = 'gLaCpGe-Aos057VIGogAZg'

  static apiURL = 'https://api.convertkit.com/v3'


  static async getSequences() {
  	const url = api.parseURLRequest(`${this.apiURL}/courses`, {
  		api_key: this.apiKey
  	})
  	const response = await axios.get(url)
  	return response.data
  }

  static async getTags() {
  	const url = api.parseURLRequest(`${this.apiURL}/tags`, {
  		api_key: this.apiKey
  	})
  	const response = await axios.get(url)
  	return response.data
  }

  static async addSubscriberToSequence(
  	sequenceID: number,
  	subscriber: {
  		email: string,
  		first_name?: string,
  		tags?: Array<number>,
  		fields?: {},
  	}
  ) {
  	const endpoint = `${sequenceID}/subscribe`
  	const options = {
  		api_key: this.apiKey,
  		...subscriber
  	}
  	const url = api.parseURLRequest(
  		`${this.apiURL}/courses/${endpoint}`,
  		options
  	)
  	const response = await axios.post(url)
  	return response.data
  }
}

export default ConvertKitAPI