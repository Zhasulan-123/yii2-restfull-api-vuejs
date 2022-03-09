import httpClient from "./http.service";

/**
 * Created by TheCodeholic on 3/7/2020.
 */
const postService = {
  create(post) {
    return httpClient.post('post', post)
  },
  get() {
    return httpClient.get('post?sort=-created_at')
  },
  update(post) {
    return httpClient.put(`post/${post.id}`, post)
  },
  delete(postId) {
    return httpClient.delete(`post/${postId}`)
  }
};

export default postService;
