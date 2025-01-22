<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div>
    <h2 class="card-title">Weather Recommendations</h2>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <p>Temperature: <span class="highlight">{{ weatherData.temperature }} °C</span></p>
      <p>Promotion Suggestion: {{ weatherData.promotionSuggestion }}</p>
      <p>Pricing Suggestion: {{ weatherData.pricingSuggestion }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      weatherData: {},
      loading: false,
    };
  },
  methods: {
    async fetchWeatherRecommendations() {
      this.loading = true;
      try {
        const response = await axios.get('http://localhost:8000/api/weather-recommendations');
        this.weatherData = response.data;
      } catch (error) {
        console.error('Error fetching weather recommendations:', error);
      } finally {
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchWeatherRecommendations();
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
  color: #28a745;
}

@media (max-width: 768px) {
  .card-title {
    font-size: 1.2rem;
  }
}
</style>
