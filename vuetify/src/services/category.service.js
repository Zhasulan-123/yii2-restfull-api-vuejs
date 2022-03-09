import httpClient from "./http.service";

/**
 * Created by TheCodeholic on 25/12/2020.
 */
const categoryService = {
  create(category) {
    return httpClient.post('category', category)
  },
  get() {
    return httpClient.get('category?sort=-created_at')
  },
  getId(category) {
    return httpClient.get(`category/${category}`)
  },
  update(category) {
    return httpClient.put(`category/${category.id}`, category)
  },
  delete(categoryId) {
    return httpClient.delete(`category/${categoryId}`)
  }
};

export default categoryService;
