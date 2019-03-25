import { useState, useEffect } from "react";
import axios from "axios";

export default (site, activeTerm, firstTerm, postType, params) => {
  const [posts, setPosts] = useState([]);

  useEffect(
    () => {
      const getPosts = async () => {
        try {
          const cachedPosts = getPostsFromCache(activeTerm);
          if (cachedPosts?.length) {
            return setPosts(cachedPosts);
          }

          const response = await axios.get(
            `${site}/wp-json/wp/v2/${postType}`,
            {
              params
            }
          );

          const postsSorted = sortPosts(firstTerm, response.data);

          addPostsToCache(activeTerm, postsSorted);
          setPosts(postsSorted);
        } catch (e) {
          console.warn(e);
          setPosts([]);
        }
      };

      getPosts();
    },
    [site, postType, params, activeTerm]
  );

  return posts;
};

function sortPosts(firstTerm, posts) {
  if (!firstTerm) {
    return posts;
  }

  const firstPosts = [];
  const otherPosts = [];

  posts.forEach(post => {
    if (post.categories.includes(parseInt(firstTerm))) {
      firstPosts.push(post);
    } else {
      otherPosts.push(post);
    }
  });

  return [...firstPosts, ...otherPosts];
}

/**
 * Cacheing functions
 */

let postsCache = {};

function getPostsFromCache(activeTerm) {
  return postsCache?.[activeTerm] || [];
}

function addPostsToCache(activeTerm, posts) {
  if (!posts?.length || activeTerm === 0) return;

  postsCache = {
    ...postsCache,
    [activeTerm]: posts
  };
}
