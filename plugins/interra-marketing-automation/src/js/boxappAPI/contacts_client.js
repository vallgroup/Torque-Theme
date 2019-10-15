// @flow
import axios from 'axios'
import api from './index'

export const sendContactForm = async (contactIfno: {
  name: string,
  email: string,
  message?: string,
}): Promise => {
  const { name, email, message } = contactIfno

  if ( '' === name ) {}

  if ( '' === email ) {}

  const user = await axios.post(`${api.contactsURL}`, {name, email, message} )

  return user.data
}