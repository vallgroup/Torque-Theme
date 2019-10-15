import {BoxAppAPIException} from '../exceptions/api_exceptions'


class BoxAppValidation {

  /**
   * conver any size in bytes
   * to B, KB, MB, GB, TB accordingly
   *
   * @param  {Number} bytes any size in bytes
   * @return {String}       the size in ints correspoinding label
   */
  bytesToSize = (bytes) => {
     var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
     if (bytes === 0) return '0 Byte';
     var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
     return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
  }

  /**
   * get the size of any bytes in KB
   *
   * @param  {Number} bytes size i nbytes
   * @return {Number}       size in KB
   */
  sizeInKB = (bytes) => {
     if (bytes === 0) return 0;
     return Math.round(bytes / Math.pow(1024, 1), 2)
  }

  /**
   * get the size of any bytes in MB
   *
   * @param  {Number} bytes size i nbytes
   * @return {Number}       size in MB
   */
  sizeInMB = (bytes) => {
     if (bytes === 0) return 0;
     return Math.round(bytes / Math.pow(1024, 2), 2)
  }

  /**
   * validate data for entire form
   * @param  {Object} data   key: value pairs for fields in a Form
   * @return {FormData}      FormData object with form values
   */
  validateFormData = (data) => {
    if (data instanceof FormData) {
      // already FormData
      // for now, just return it
      return data;
    }

    // not FormData, we expect on object
    let _formData = new FormData()

    for (var i in data) {
      if (data.hasOwnProperty(i)) {
        if ('undefined' !== typeof data[i]
          && null !== data[i]) {
          this.validateField(data[i])
          _formData.append(i, data[i])
        }
      }
    }
    return _formData;
  }

  /**
   * validate a specific field
   *
   * @param  {Object} field field object
   * @return {Boolean}       True on validation success, false otherwise
   */
  validateField = (field) => {
    switch(field.constructor.name) {
      case 'File':
        this.validateFile(field)
      break;

      default:

      break;
    }
  }

  /**
   * validate a file field
   * @param  {Object} file File object
   * @return {void}
   */
  validateFile = (file) => {

    // ensure file size does not exceed 128MB
    // our server is currenlty limited to this size
    if (20000000 < this.sizeInKB(file.size)) {
      throw new BoxAppAPIException('File size exceeds limit, 128 MB.')
    }

    return true;
  }


  validateNewWorld(world) {
    if(!world.pano_media && !world.pano_video) {
      throw new BoxAppAPIException('Creatign a world requires a 360 Image or video');
    }

    if(!world.name) {
      throw new BoxAppAPIException('Creatign a world requires a name');
    }

    return true;
  }

  validateName(name) {
    name = name || ''

    if('' === name
      || 2 > name.length) {
      throw new BoxAppAPIException('Name cannot be empty and must be at least 2 characters long.');
    }

    if(null !== name.trim().match(/[^a-zA-Z]/)) {
      throw new BoxAppAPIException('Name can only contain letters.');
    }

    return true;
  }

  validateEmail(email) {
    email = email || ''

    const regExp = RegExp(/^([^@|",[\]/;:])+@+([^@|",[\]/;:.]*)+(\.[a-zA-Z]*)(\.[a-zA-Z]{1,2})?$/, 'g')
    if(!regExp.test(email)) {
      throw new BoxAppAPIException('Email is not valid.');
    }

    return true;
  }

  validateUsername(username) {
    username = username || ''

    if(4 > username.length) {
      throw new BoxAppAPIException('Your username must be at least 4 characters long.');
    }

    const regExp = RegExp(/[^a-zA-Z0-9_]/, 'g')
    if(regExp.test(username)) {
      throw new BoxAppAPIException('Please use only alphanumeric characters and "_" for the username.');
    }

    return true;
  }

  validatePassword(pass) {
    pass = pass || ''

    if(8 > pass.length) {
      throw new BoxAppAPIException('The password must be at least 8 characters long.');
    }

    return true;
  }

  validateCKTag(tag) {
    tag = tag || 0

    if(0 === +tag) {
      throw new BoxAppAPIException('Please choose how you will use BoxApp.');
    }

    return true;
  }
}

export default new BoxAppValidation()