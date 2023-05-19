import axios from "axios";

// const refreshToken = () => {
//     axios.post
// }
const axiosApiInstance = axios.create();
axiosApiInstance.interceptors.request.use(
    async config => {
       
        const TOKEN = localStorage.getItem("sgtoken")
        console.log(TOKEN);
      config.headers = { 
        Authorization: `Bearer ${TOKEN}`,
        "Content-Type": "multipart/form-data",

      }
      return config;
    },
    error => {
      Promise.reject(error)
  });


// axios.interceptors.response.use((res) => {
//     const TOKEN = localStorage.getItem("sgtoken")
//     console.log(TOKEN);
//     res.headers = { 
//         "Content-Type": "multipart/form-data",
//         Authorization: `Bearer ${TOKEN}`
//     }
//     return res
// }, async function (err) {
//     if (localStorage.getItem("sgtoken") && err.response.status === 401) {

//     }
// })
