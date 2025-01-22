<template>
  <div class="dashboard">
    <header class="dashboard-header">
      <h1>Dashboard</h1>
    </header>
    <main class="dashboard-main">
      <section class="card">
        <AddOrder />
      </section>
      <section class="card">
        <Analytics />
      </section>
      <section class="card">
        <Weather />
      </section>
      <section class="card">
        <Recommendations />
      </section>
    </main>
  </div>
</template>

<script>
import AddOrder from './components/AddOrder.vue'; // AddOrder component
import Analytics from './components/Analytics.vue'; // Analytics component
import Weather from './components/weather.vue'; // Weather component
import Recommendations from './components/Recommendations.vue'; // Recommendations component

export default {
  components: { AddOrder, Analytics, Weather, Recommendations },
};
</script>

<style scoped>
/* General Dashboard Styles */
.dashboard {
  width: 100%;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #f7f9fc;
  font-family: Arial, sans-serif;
  box-sizing: border-box;
  padding: 20px;
}

.dashboard-header {
  width: 100%;
  text-align: center;
  margin-bottom: 20px;
}

.dashboard-header h1 {
  font-size: 2rem;
  color: #333;
}

.dashboard-main {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  width: 100%;
  max-width: 1200px; /* Keeps the layout centered */
}

/* Card Styles */
.card {
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 20px;
  flex: 1 1 300px; /* Flex item with a minimum size of 300px */
  max-width: 400px;
  text-align: left;
}

/* Media Queries for Responsive Design */
@media (max-width: 768px) {
  .dashboard-main {
    flex-direction: column;
    align-items: center;
  }

  .card {
    width: 100%; /* Cards take full width on smaller screens */
  }
}
</style>
