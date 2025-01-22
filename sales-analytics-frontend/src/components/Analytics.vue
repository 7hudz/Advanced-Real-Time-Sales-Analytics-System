<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div>
    <h2 class="card-title">Analytics</h2>
    <p>Total Revenue: <span class="highlight">{{ analytics.totalRevenue }}</span></p>
    <ul>
      <li v-for="product in analytics.topProducts" :key="product.product_id">
        Product {{ product.product_id }} - Sold: {{ product.sold }}
      </li>
    </ul>
    <p>Recent Orders (Last 1 Minute): <span class="highlight">{{ analytics.recentOrders }}</span></p>
  </div>
</template>

<script>
import api from '../services/api';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
  data() {
    return {
      analytics: {
        totalRevenue: 0,
        topProducts: [],
        recentOrders: 0,
      },
    };
  },
  created() {
    this.fetchAnalytics(); // Fetch initial analytics data
    this.listenForNewOrder(); // Listen for new orders and update analytics
  },
  methods: {
    async fetchAnalytics() {
      try {
        const response = await api.get('/analytics');
        this.analytics = response.data;
      } catch (error) {
        console.error('Error fetching analytics:', error);
        alert('Error fetching analytics');
      }
    },
    listenForNewOrder() {
      // Initialize Pusher and Echo for real-time updates
      const pusher = new Pusher('c61d6a894bce05dfb3f9', {
        cluster: 'eu',
        encrypted: true,
      });

      window.Echo = new Echo({
        broadcaster: 'pusher',
        client: pusher,  // Assign Pusher client
      });

      // Listen to 'orders' channel for 'OrderAdded' event
      window.Echo.channel('orders')
        .listen('OrderAdded', (event) => {
          this.updateAnalytics(event.order);
        })
        .error((error) => {
          console.error('Echo Error:', error);
        });
    },
    updateAnalytics(order) {
      // Update total revenue and top products
      this.analytics.totalRevenue += order.price * order.quantity;
      const product = this.analytics.topProducts.find(p => p.product_id === order.product_id);
      if (product) {
        product.sold += order.quantity;
      } else {
        this.analytics.topProducts.push({
          product_id: order.product_id,
          sold: order.quantity,
        });
      }
      this.analytics.recentOrders += 1;
    },
  },
};
</script>

<style scoped>
.card-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 10px;
}

.highlight {
  font-weight: bold;
  color: #007bff;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 5px 0;
}

@media (max-width: 768px) {
  .card-title {
    font-size: 1.2rem;
  }

  li {
    font-size: 0.9rem;
  }
}
</style>
