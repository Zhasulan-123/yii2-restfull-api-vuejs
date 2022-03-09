import httpClient from "./http.service";

/**
 * Created by TheCodeholic on 30/12/2020.
 */
const tagsService = {
  create(tags) {
    return httpClient.post('tags', tags)
  },
  get() {
    return httpClient.get('tags?sort=-created_at')
  },
  update(tags) {
    return httpClient.put(`tags/${tags.id}`, tags)
  },
  delete(tagsId) {
    return httpClient.delete(`tags/${tagsId}`)
  }
};

export default tagsService;
