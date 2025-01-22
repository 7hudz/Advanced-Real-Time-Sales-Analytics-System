<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="recommendations">
    <h2>Product Promotion Recommendations</h2>

    <!-- Display recommendations only if they exist -->
    <div v-if="recommendations && recommendations.length > 0">
      <ul>
        <li v-for="(recommendation, index) in recommendations" :key="index">
          {{ recommendation }}
        </li>
      </ul>
    </div>

    <!-- Display a message if there are no recommendations -->
    <div v-else>
      <p>No recommendations available.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      recommendations: [], // Default to an empty array
    };
  },
  async mounted() {
    try {
      // Fetch recommendations from the backend API
      const response = await axios.get('/api/get-recommendations');

      // Check if recommendations are an array and assign them
      if (Array.isArray(response.data.recommendations)) {
        this.recommendations = response.data.recommendations;
      } else {
        // Handle unexpected response format (if it's a string or empty)
        this.recommendations = response.data.recommendations
          ? [response.data.recommendations] // Convert string to array if needed
          : [];
      }
    } catch (error) {
      console.error('Error fetching recommendations:', error);
      this.recommendations = []; // Fallback to an empty array if an error occurs
    }
  },
};
</script>

<style scoped>
.recommendations {
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h2 {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 10px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  padding: 8px;
  background-color: #f9f9f9;
  margin-bottom: 5px;
  border-radius: 4px;
}

p {
  color: #888;
}
</style>
