import { useState, useEffect } from "react";
import axios from "axios";

export default (site, activeTerm, params) => {
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
            `${site}/wp-json/filtered-loop/v1/posts`,
            {
              params
            }
          );

          if (response?.data?.success && response?.data?.posts) {
            addPostsToCache(activeTerm, response.data.posts);
            return setPosts(response.data.posts);
          }

          setPosts([]);
        } catch (e) {
          console.warn(e);
          setPosts([]);
        }
      };

      getPosts();
    },
    [site, params, activeTerm]
  );

  return posts;
};

/**
 * Cacheing functions
 */

let postsCache = {};

function getPostsFromCache(activeTerm) {
  if (!activeTerm) return [];

  return postsCache?.[activeTerm] || [];
}

function addPostsToCache(activeTerm, posts) {
  if (!posts?.length || !activeTerm) return;

  postsCache = {
    ...postsCache,
    [activeTerm]: posts
  };
}
