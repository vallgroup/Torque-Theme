
import axios from 'axios'
import api from './index'
// import BoxAppValidation from './axios/validations'

export const getCategories = async () => {
	const url = `${api.wpAPIRoot}/categories`
	const response = await axios.get(url)
	return response.data
}