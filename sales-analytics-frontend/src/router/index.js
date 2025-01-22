import { createRouter, createWebHistory } from 'vue-router';
import App from '../App.vue';
import AddOrder from '../components/AddOrder.vue';



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: App, // Home route
    },
    {
      path: '/order', // Add route for /order
      name: 'order',
      component: AddOrder, // AddOrder component for this path
    },
  
    // You can add more routes here for other components as needed
  ],
});

export default router;

