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
    displayIndex(index) {
      return index + 1;
    },
    getPrice(price , quantity) {
      return price * quantity;
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
    categoryInfo(id : any) {
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/category/'+id;
        axiosInstance.get(url)
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    productList(){
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/product';
        axiosInstance.get(url)
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    productInfo(id : any) {
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
    invoiceInfo(id : any) {
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/invoice/'+id;
        axiosInstance.get(url)
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    invoiceDetail(id : any) {
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/invoiceDetail/'+id;
        axiosInstance.get(url)
          .then(response => {
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    invoiceList(){
      return new Promise((resolve, reject) => {
        const url = Config.API_ENDPOINT+'/invoice';
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
