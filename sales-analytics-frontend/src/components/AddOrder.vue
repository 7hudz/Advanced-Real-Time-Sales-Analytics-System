<template>
  <form @submit.prevent="addOrder" class="order-form">
    <div>
      <label for="product_id">Product ID</label>
      <input v-model="order.product_id" id="product_id" placeholder="Product ID" required />
    </div>
    <div>
      <label for="quantity">Quantity</label>
      <input v-model.number="order.quantity" id="quantity" placeholder="Quantity" type="number" required />
    </div>
    <div>
      <label for="price">Price</label>
      <input v-model.number="order.price" id="price" placeholder="Price" type="number" required />
    </div>
    <div>
      <label for="date">Date</label>
      <input v-model="order.date" id="date" placeholder="Date" type="date" required />
    </div>
    <button type="submit">Add Order</button>
  </form>

  <!-- Displaying real-time updates -->
  <h3>Latest Order Added</h3>
  <div v-if="latestOrder">
    <p>Product ID: {{ latestOrder.product_id }}</p>
    <p>Quantity: {{ latestOrder.quantity }}</p>
    <p>Price: {{ latestOrder.price }}</p>
    <p>Date: {{ latestOrder.date }}</p>
  </div>
</template>

<script>
import axios from 'axios';
import api from '../services/api';

// Import Echo and Pusher at the top of the file
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
  data() {
    return {
      order: {
        product_id: '',
        quantity: 0,
        price: 0.0,
        date: '',
      },
      latestOrder: null,
    };
  },
  created() {
    this.loadEcho(); // Dynamically load Echo and initialize the listener
  },
  methods: {
    async addOrder() {
      try {
        // Sending the order to the backend
        await api.post('/orders', this.order);
        alert('Order added successfully');
      } catch (error) {
        console.error('Error adding order:', error);
        alert('Error adding order');
      }
    },
    // Dynamically load and initialize Echo
    async loadEcho() {
      try {
        // Initialize Pusher and Echo here
        window.Pusher = Pusher;
        window.Echo = new Echo({
          broadcaster: 'pusher',
          key: 'c61d6a894bce05dfb3f9',  // Replace with your Pusher App Key
          cluster: 'eu',  // Replace with your Pusher App Cluster
          encrypted: true,
        });

        // Start listening for new order events
        this.listenForNewOrder();
      } catch (error) {
        console.error('Error loading Echo:', error);
      }
    },
    // Listen for new orders broadcast from Laravel
    listenForNewOrder() {
      if (window.Echo) {
        window.Echo.channel('orders')
          .listen('OrderAdded', (event) => {
            this.latestOrder = event.order;
          })
          .error((error) => {
            console.error('Error in Echo listener:', error);
          });
      } else {
        console.error('Echo is not initialized');
      }
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

.order-form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

label {
  font-weight: bold;
  margin-bottom: 5px;
}

input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
}

button {
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  box-sizing: border-box;
}

button:hover {
  background-color: #0056b3;
}

@media (max-width: 768px) {
  input,
  button {
    font-size: 0.9rem;
  }
}
</style>
