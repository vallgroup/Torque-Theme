// @flow
import type { UserLogin, User } from '../src/flow-typed/user_types'
import axios from 'axios'
import { btoa } from 'Base64'
import api from './index'

export const logIn = async (newLogin: UserLogin): Promise<{token: string, user: User}> => {
  const { username, password } = newLogin

  const token = _newToken(username, password)

  // const user = await getCurrentUser(token)

  const response = await axios.post(`${api.usersURL}/login?timestamp=${new Date().getTime()}`, {token})

  if (false === response.data.success) {
    return response.data
  }

  if ( response.data.hasOwnProperty('two_factor_auth_code_sent') ) {
    response.data.token = token
    return response.data
  }

  if ( response.data.user ) {
    return {
      token,
      user: response.data.user
    }
  }
}

export const verify2FACode = async (args: {
  user_id: number,
  code: string,
}): Promise<User> => {
  const response = await axios.post(`${api.usersURL}/check-tfa-code`, args)

  if (200 === response.status
    && true === response.data.success) {
    return response.data.user
  }
}

export const resend2FACode = async (user_id: number): Promise<User> => {
  const response = await axios.post(`${api.usersURL}/resend-tfa-code`, {user_id})

  if (200 === response.status
    && true === response.data.success) {
    return response.data
  }
}

export const getCurrentUser = async (token: string): Promise<User> => {
  const response = await axios.get(api.currentUserURL, {
    headers: api.getAuthorizedGetRequestHeaders(token)
  })

  if (200 === response.status
    && response.data.id) {
    const publicUser = await getPublicUser(response.data.id)
    return publicUser.user;
  }
  return response.data
}

export const loadFullUser = async (userID: number, token: string): Promise<User> => {
  const response = await axios.get(`${api.wpUsersURL}/${userID}?context=edit`, {
    headers: api.getAuthorizedGetRequestHeaders(token)
  })

  return response.data
}

export const getUser = async (userID: number): Promise<User> => {
  const response = await axios.get(`${api.wpUsersURL}/${userID}?context=view`)

  return response.data
}

export const getUsers = async (): Promise<User> => {
  const response = await axios.get(`${api.usersURL}`)

  return response.data
}

export const getPublicUser = async (userID: number): Promise<User> => {
  const response = await axios.get(`${api.usersURL}/${userID}`)

  return response.data
}

export const forgotPassword = async (username: string): Promise<User> => {

  const url = api.parseURLRequest(`${api.usersURL}/forgot-password`, {username})
  const response = await axios.get(url)

  return response.data
}

export const forgotUsername = async (email: string): Promise<User> => {

  const url = api.parseURLRequest(`${api.usersURL}/forgot-username`, {email})
  const response = await axios.get(url)

  return response.data
}

export const deleteUser = async (userID: number, token: string): Promise => {
  const url = api.parseURLRequest(`${api.usersURL}/${userID}`, {})
  const response = await axios.delete(url, {
    headers: api.getDeleteRequestHeaders(token)
  })

  return response.data
}

export const registerUser = async (args: {
  username: string,
  email: string,
  password: string,
}): Promise<User> => {

  const url = api.parseURLRequest(
    `${api.usersURL}/register`,
    args)

  const response = await axios.post(url)

  return response.data
}

export const updateUser = async (userID: number, args: {
  name?: string,
  email?: string,
  password?: string,
}, token: string): Promise<User> => {

  const response = await axios.post(`${api.usersURL}/${userID}`, args, {
    headers: api.getPostRequestHeaders(token)
  })

  return response.data && response.data.user
}

export const createUser = async (args: {
  name: string,
  email: string,
  password: string,
}, token: string): Promise<User> => {

  const response = await axios.post(`${api.usersURL}`, args, {
    headers: api.getPostRequestHeaders(token)
  })

  return response.data
}

export const userExists = async (args: {
  username?: string,
  email?: string,
}, token: string): Promise<User> => {

  const response = await axios.post(`${api.usersURL}/user-exists`, args, {
    headers: api.getPostRequestHeaders(token)
  })

  return response.data && response.data.user_exists
}

export const followUser = async (userID: number, followerID: number, token: string): Promise<User> => {
  const url = api.parseURLRequest(`${api.followURL}${userID}`, {follower: followerID})

  const response = await axios.post(url, {}, {
    headers: api.getPostRequestHeaders(token),
  })

  return response.data
}

/**
 * Private methods
 */
function _newToken (username: string, password: string): string {
  return _createBase64Auth(username, password)
}

function _createBase64Auth (username: string, password: string): string {
  return btoa(username + ':' + password)
}
