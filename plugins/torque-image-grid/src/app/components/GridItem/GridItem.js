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
 