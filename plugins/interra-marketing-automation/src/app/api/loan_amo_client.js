import axios from 'axios'

const __url = '/wp-json/ima/v1/loan-amortization';

export const getLoanAmo = async ( docID ) => {
	if (!docID) return;

	try {
		const response = await axios.get(`${__url}/${docID}`)
		return response.data
	} catch(err) {
		console.error(err)
	}
}