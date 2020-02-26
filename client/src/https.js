import axios from 'axios'
import qs from 'qs'
import router from './router'

axios.defaults.timeout = 5000;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
axios.defaults.baseURL = 'http://qim.colocust.cn/api/';

//POST传参序列化(添加请求拦截器)
axios.interceptors.request.use((config) => {
  if (config.method === 'post') {
    config.data = qs.stringify(config.data);
  }
  return config;
}, (error) => {
  console.log('错误的传参')
  return Promise.reject(error);
});

axios.interceptors.response.use((res) => {
  if(res.data.code === 401) {
    router.push('/login');
  }
  if (!res.data.success) {
    return Promise.resolve(res);
  }
  return res;
}, (error) => {
  console.log('网络异常');
  return Promise.reject(error);
});

export function fetchPost(url, params) {
  return new Promise((resolve, reject) => {
    params.token = localStorage.getItem('token');
    axios.post(url, params)
      .then(response => {
        resolve(response);
      }, err => {
        reject(err);
      })
      .catch((error) => {
        reject(error)
      })
  })
}

export function fetchGet(url, param) {
  return new Promise((resolve, reject) => {
    axios.get(url, {params: param})
      .then(response => {
        resolve(response)
      }, err => {
        reject(err)
      })
      .catch((error) => {
        reject(error)
      })
  })
}

export default {
  fetchPost,
  fetchGet,
}
