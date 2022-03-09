import httpClient from "./http.service";

/**
 * Created by TheCodeholic on 21/12/2020.
 */
const pageService = {
  create(page) {
    return httpClient.post('page', page)
  },
  get() {
    return httpClient.get('page?sort=-created_at')
  },
  getId(id) {
    return httpClient.get(`page/${id}`)
  },
  update(page) {
    return httpClient.put(`page/${page.id}`, page)
  },
  delete(pageId) {
    return httpClient.delete(`page/${pageId}`)
  }
};

export default pageService;
