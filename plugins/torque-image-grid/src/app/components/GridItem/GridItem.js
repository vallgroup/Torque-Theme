import React from 'react'
import {
  ImageGridImageWrapper,
  ImageGridImageLink,
  ImageGridImage
} from '../../styles/styles'

const GridItem = ({
  image,
  imagesPerRow
}) => {
  
  // // Not in-use, as using ACF 'link' field which includes target
  // // add to element: onClick={((e) => handleImageClick(e, image.media_link.url))}
  // function handleImageClick (e, imageLink) {
  //   // stop default behaviour
  //   e.preventDefault()
  //   e.stopPropagation()
  //   const currHostname = location.hostname // window url hostname
  //   const imgLinkHostname = e.target.parentElement.hostname // element url hostname
  //   // console.log('currHostname', currHostname)
  //   // console.log('imgLinkHostname', imgLinkHostname)
  //   if ( currHostname === imgLinkHostname ) {
  //     // if of some origin, open in same tab/window
  //     window.open(imageLink, '_self')
  //   } else {
  //     // open in new tab/window
  //     window.open(imageLink, '_blank')
  //   }
  // }

  return (
    <ImageGridImageWrapper
      className="image-grid-image-wrapper"
      imagesPerRow={imagesPerRow}
    >
      {(image.media_link && image.media_link.url && '' !== image.media_link.url)
        ? (<ImageGridImageLink 
          href={image.media_link.url}
          target={image.media_link.target}
        >
          <ImageGridImage
            src={image.url}
            alt={image.alt}
          />
        </ImageGridImageLink>)
        : <ImageGridImage
          src={image.url}
          alt={image.alt}
        />
      }
      
    </ImageGridImageWrapper>
  )
}

export default GridItem
