<script setup>

</script>

<template>
    <div class="app-layout">
        <nav class="navbar">
            <router-link to="/">Home</router-link>
            <router-link to="/search">Search</router-link>
            <router-link to="/create">Create</router-link>
        </nav>
        <main class="content">
            <router-view></router-view>
        </main>
    </div>
</template>

<style scoped>
.app-layout{
    margin:0 auto;
    font-family: system-ui, -apple-system, sans-serif;
}

.navbar{
    display: flex;
    gap:15px;
    background-color: #ffffff;
    padding: 14px 20px;
    border-radius: 13px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar a {
    text-decoration: none;
    color: #3b82f6;
    font-weight: 600;
    transition: color 0.2s;
}

.navbar a.router-link-active {
    color: #0f172a;
    border-bottom: 2px solid #0f172a;
}
</style>
