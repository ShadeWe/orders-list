export default [
    {
        name: 'home',
        path: '/',
        component: require("./components/Pages/Weather").default
    },
    {
        name: 'orders',
        path: '/orders',
        component: require("./components/Pages/OrderList").default,
    },
    {
        path: '/orders/edit/:order_id',
        component: require("./components/Pages/OrderEdit").default
    }
];