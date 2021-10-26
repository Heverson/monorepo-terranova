import axios from "axios";
/**
 * Api Serverless
 * Endpoints
 *  POST => /sessions/app
 *  POST => /users/create
 *  GET =>  /etapas/
 *  POST => /etapas/ (verificar parametros JSON)
 *  GET =>  /etapas/:idObra
 *  PUT =>  /etapas/ (verificar parametros JSON)
 *  GET =>  /obras/
 *  GET =>  /obras/ambientes/:idObra
 *  POST => /obras/
 *  PUT => /obras/
 *  GET =>  /obra/:idObra
 */
const endpoints = {
  // API: 'http://127.0.0.1:3000/dev/',
  // API: 'https://z0p321kaqa.execute-api.us-east-1.amazonaws.com/',
  API: "https://f7aosyhl04.execute-api.us-east-1.amazonaws.com/dev/",
};

const api = axios.create({
  baseURL: endpoints.API,
});

export { api, endpoints };
