import httpClient from "./http.service";

/**
 * Created by TheCodeholic on 02/01/2021.
 */
const blogsService = {
  create(blog) {
    return httpClient.post('blog', blog)
  },
  get() {
    return httpClient.get('blog?sort=-created_at')
  },
  getTags(tags) {
    return httpClient.get(`blog?expand=${tags}`)
  },
  update(blog) {
    return httpClient.put(`blog/${blog.id}`, blog)
  },
  delete(blogId) {
    return httpClient.delete(`blog/${blogId}`)
  }
};

export default blogsService;
