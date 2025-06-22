const ENV = {
    development: {
        API_URL: 'http://localhost/api',
        IMG_BASE: '/imgProdutos'
    },
    production: {
        API_URL: 'https://seusite.com/api',
        IMG_BASE: 'https://cdn.seusite.com/img'
    }
};

export default ENV[process.env.NODE_ENV || 'development'];