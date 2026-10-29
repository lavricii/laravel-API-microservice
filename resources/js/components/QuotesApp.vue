<script setup>
import { ref, onMounted } from "vue";
import QuotesCard from "./QuotesCard.vue";

const quotes = ref([]);
const isLoading = ref(true);
const errorMessage = ref('');

const fetchQuotes = async () => {
    try {
        const response = await fetch('/api/quote')
        if (!response.ok) {
            throw new Error(`Server returned status: ${response.status}`)
        }
        quotes.value = await response.json()
    } catch (error) {
        console.error('API Error:', error)
        errorMessage.value = 'Failed to load quotes. Please try again.'
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchQuotes()
});

const handleQuoteDeleted = (deletedId) => {
    quotes.value = quotes.value.filter(q => q.id !== deletedId)
}
</script>

<template>
    <div class="container">
        <header class="header">
            <h2>Overview</h2>
            <span v-if="!isLoading" class="badge">{{ quotes.length }} Total</span>
        </header>

        <div v-if="isLoading" class="state-message">
            Loading quotes...
        </div>

        <div v-else-if="errorMessage" class="state-message error">
            {{ errorMessage }}
        </div>

        <div v-else-if="quotes.length > 0" class="list">
            <QuotesCard
                v-for="quote in quotes"
                :key="quote.id"
                :quote="quote"
                @quote-deleted="handleQuoteDeleted"
            />
        </div>

        <div v-else class="state-message">
            No quotes found.
        </div>
    </div>
</template>

<style scoped>
.container {
    max-width: 400px;
    margin: auto;
    padding: 30px;
    background-color: #f8fafc;
    border-radius: 15px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    font-family: system-ui, -apple-system, sans-serif;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

h2 {
    margin: 0;
    font-size: 1.25rem;
    color: #0f172a;
}

.badge {
    background-color: #e2e8f0;
    color: #475569;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 12px;
}

.list {
    display: flex;
    flex-direction: column;
}

.state-message {
    text-align: center;
    color: #64748b;
    padding: 10px 0;
}

.error {
    color: #dc2626;
}
</style>
