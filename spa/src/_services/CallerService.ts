// _services/CallerService.ts
import axios from 'axios';

const Axios = axios.create({
    baseURL: 'https://windigoprint-backend.fohu7030.odns.fr',
    headers: {
      Accept: 'application/json'
    },
    withCredentials: true, // axios va copier les cookies d'auth dans le header de la requête
    withXSRFToken: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN'
  });
export default Axios;