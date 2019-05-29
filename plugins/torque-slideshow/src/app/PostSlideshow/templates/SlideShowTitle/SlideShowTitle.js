import React, { memo } from "react";
import PropTypes from "prop-types";

const SlideShowTitle = ({ post, title }) => {
   if ( post.permalink.includes('/listing/') ) {
      title = 'Featured Listing';
   } else {
      title = '';
   }
   
   return (
      <h4 className="slider-title">{title}</h4>
   );
}

SlideShowTitle.propTypes = {
   title: PropTypes.string,
   post: PropTypes.object
};

SlideShowTitle.defaultProps = {
   title: ""
 };


export default memo(SlideShowTitle);