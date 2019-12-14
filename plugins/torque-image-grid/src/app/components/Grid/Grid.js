import React from 'react'
import GridItem from '../GridItem/GridItem'
import {
  ImageGridContentWrapper,
  ImageGridTitle,
  ImageGridContent,
  ImageGridImageContainer
} from '../../styles/styles'

const Grid = ({
  grid
}) => {
  return (
    <ImageGridContentWrapper className="image-grid-content-wrapper">
      {'' !== grid.title &&
        <ImageGridTitle>{grid.title}</ImageGridTitle>
      }
      {'' !== grid.content &&
        <ImageGridContent>{grid.content}</ImageGridContent>
      }
      <ImageGridImageContainer className={`image-grid-image-container num-images-per-row-${grid.images_per_row}`}>
        {grid.images.map((image, index) => {
          return <GridItem
              key={image.ID}
              image={image}
              imagesPerRow={grid.images_per_row}
            />
        })}
      </ImageGridImageContainer>
    </ImageGridContentWrapper>
  )
}

export default Grid
