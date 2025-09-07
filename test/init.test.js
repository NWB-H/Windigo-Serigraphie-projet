const axios = require('axios');

const Axios = axios.create({
    baseURL: 'http://windigoprint-backend.fohu7030.odns.fr/api',
    headers: {
        Accept: 'application/json'
    }
});

const user = {};

describe("User Login", () => {
    test("Vérification de l'authentification", async () => {
        await login(user, {
            email: 'user@windigo.com',
            password: 'test123'
        });
    });
});

describe("Products GET", () => {
    test('Récupération de la liste des produits', async () => {
        const res = await Axios.get('/products');
        expect(res.data.products.length).toBeGreaterThanOrEqual(2);
    });

    test('Get Show', async () => {
        const products = await Axios.get('/products');
        const res = await Axios.get('/products/' + products.data.products[0].id);
        expect(res.data.name).toBeTruthy();
        expect(res.data.price).toBeGreaterThanOrEqual(1);
        expect(res.data.price).toBeLessThanOrEqual(100);
    });
});

describe("products POST", () => {
    test("Create with good data", async (data = { name: 'Jaune Impérial', price: 34, stock: 5, description: 'Reprehenderit reprehenderit ipsum est est illo error. Sint suscipit nihil id dolor dignissimos rerum.', archived: 0, option_id: 4, category_id: 4, picture: null}) => {
        const old = await Axios.get('/products');

        const oldNumProducts = old.data.products.length;
        // before
            const createRes = await Axios.post('/admin/products', data);
        // after
        const cur = await Axios.get('/products');
        const curNumProducts = cur.data.products.length;

        expect(createRes.data.name).toBe('Jaune Impérial');
        expect(curNumProducts).toBe(oldNumProducts + 1);
    });

    test("Create with bad data", async (data = { name: 'Jaune Impérial', price: 54, stock: 5, description: 'Reprehenderit reprehenderit ipsum est est illo error. Sint suscipit nihil id dolor dignissimos rerum.', archived: 0, option_id: 4, category_id: 4, picture: null }) => {
        const old = await Axios.get('/products');
        const oldNumProducts = old.data.products.length;
        // before
        const createRes = await Axios.post('/admin/products', data, { validateStatus: () => true });
        // after
        const cur = await Axios.get('/products');
        const curNumProducts = cur.data.products.length;

        expect(createRes.status).toBe(422);
        expect(curNumProducts).toBe(oldNumProducts);
    });
});

//   describe("Products PUT", () => {
//     test("Update as user owner", async (data = { name: 'New name', _method: 'PUT' }) => {
//       const res = await Axios.get('/products');
//       const product = res.data.products.find(c => c.user_id == user.id);
//       const updateRes = await Axios.post('/products/' + product.id, data);
//       expect(updateRes.data.products.name).toBe('New name');
//     });

//     test("Update as not user owner", async (data = { name: 'New name', _method: 'PUT' }) => {
//       const res = await Axios.get('/products');
//       const product = res.data.products.find(c => c.user_id != user.id);
//       const updateRes = await Axios.post('/products/' + product.id, data, { validateStatus: () => true });
//       expect(updateRes.status).toBe(403);
//       expect(updateRes.data.products.name).not.toBe('New name');
//     });
//   });

// describe("Products DELETE", () => {
//     test("Delete as user owner", async () => {
//       const old = await Axios.get('/products');
//       const product = old.data.products.find(c => c.user_id == user.id);
//       const oldNumProduct = old.data.products.length;
//       // before
//       const deleteRes = await Axios.delete('/products/' + product.id);
//       // after
//       const cur = await Axios.get('/products');
//       const curNumProduct = cur.data.products.length;

//       expect(deleteRes.status).toBe(200);
//       expect(curNumProduct).toBe(oldNumProduct - 1);
//     });

//     test("Delete as not user owner", async () => {
//       const old = await Axios.get('/products');
//       const product = old.data.products.find(c => c.user_id != user.id);
//       const oldNumProduct = old.data.products.length;
//       // before
//       const deleteRes = await Axios.delete('/products/' + product.id, { validateStatus: () => true });
//       // after
//       const cur = await Axios.get('/products');
//       const curNumProduct = cur.data.length;

//       expect(deleteRes.status).toBe(403);
//       expect(curNumProduct).toBe(oldNumProduct);
//     });
//   });


describe("Admin Login", () => {
    test("Vérification de l'authentification", async () => {
        await login(user, {
            email: 'admin@windigo.com',
            password: 'test123'
        });
    });
});

describe("Admin products PUT", () => {
    test("Update as admin", async (data = { name: 'New name', _method: 'PUT' }) => {
      const res = await Axios.get('/products');
      const product = res.data.products.find(c => c.user_id != user.id);

      await Axios.post('/admin/products/' + product.id, data);
      const updateProduct = await Axios.get('/products/' + product.id);
      expect(updateProduct.data.name).toBe('New name');
    });
  });

describe("Admin Products DELETE", () => {
    test("Delete as admin", async () => {
        const old = await Axios.get('/products');
        const product = old.data.products.find(c => c.user_id != user.id);
        const oldNumProduct = old.data.products.length;
        // before
        const deleteRes = await Axios.delete('/admin/products/' + product.id);
        // after
        const cur = await Axios.get('/products');
        const curNumProduct = cur.data.products.length;

        expect(deleteRes.status).toBe(200);
        expect(curNumProduct).toBe(oldNumProduct - 1);
    });
});

async function login(user, credentials) {
    await Axios.get('/logout', {
        baseURL: 'http://windigoprint-backend.fohu7030.odns.fr'
    });

    const res = await Axios.get('/sanctum/csrf-cookie', {
        baseURL: 'http://windigoprint-backend.fohu7030.odns.fr'
    });

    Axios.defaults.headers.cookie = res.headers['set-cookie'];
    Axios.defaults.headers.common['X-XSRF-TOKEN'] = parseCSRFToken(res.headers['set-cookie']);
    Axios.defaults.headers.common['Origin'] = 'http://windigoprint-backend.fohu7030.odns.fr';
    Axios.defaults.headers.common['Referer'] = 'http://windigoprint-backend.fohu7030.odns.fr';

    const auth = await Axios.post('/authenticate', credentials, {
        baseURL: 'http://windigoprint-backend.fohu7030.odns.fr',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    });

    Axios.defaults.headers.cookie = auth.headers['set-cookie'];
    Axios.defaults.headers.common['X-XSRF-TOKEN'] = parseCSRFToken(auth.headers['set-cookie'])

    for (let key in auth.data.user) {
        user[key] = auth.data.user[key];
    }
}

function parseCSRFToken(cookies) {
    const startAt = cookies[0].indexOf('=');
    const endAt = cookies[0].indexOf(';');
    const csrf = cookies[0].substring(startAt + 1, endAt - 3);
    return csrf;
}

