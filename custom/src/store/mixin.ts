import axiosInstance from './axiosInstance';
import Config from './config';

export const myMixin = {
  data() {
    return {

    };
  },
  created() {

  },
  methods: {
    render(level: number) {
      let result = '';
      if (level>0) {
        for (let i = 0; i < level; i++) {
          result += ' - ';
        }
        return ' '+result+' ';
      } else {
        return '';
      }
    },
    categoryList() {
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/category';
        axiosInstance.get(url)
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    productInfo(id) {
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/product/'+id;
        axiosInstance.get(url)
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
  }
};
