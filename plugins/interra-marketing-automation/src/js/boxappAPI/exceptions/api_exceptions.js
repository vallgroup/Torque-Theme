export function BoxAppAPIException (message: mixed) {
	this.defaultMessage = 'Something went wrong.'
	
	if ('string' === typeof message) {
  		this.message = message || this.defaultMessage
  		this.code = 400
	} else {
		this.message = message.data.message || this.defaultMessage
  		this.code = message.data.status || 400
	}
  this.name    = 'BoxAppAPIException'
}

export const badWorldID = (worldId: number) => {
  return `Invalid worldID, got ${worldId}`
}