<script setup>
import { ref } from 'vue'

import QuotesCard from './QuotesCard.vue'

const searchQuery = ref('')
const results = ref([])
const isSearching = ref(false)
const hasSearched = ref(false)

const handleSearch = async () => {
    if (!searchQuery.value.trim()) return

    isSearching.value = true
    hasSearched.value = true

    try {
        const response = await fetch(`/api/quote/search?query=${encodeURIComponent(searchQuery.value)}`)
        if (response.ok) {
            results.value = await response.json()
        }
    } catch (error) {
        console.error('Search request failed:', error)
    } finally {
        isSearching.value = false
    }
}

const handleQuoteDeleted = (deletedId) => {
    results.value = results.value.filter(q => q.id !== deletedId)
}
</script>

<template>
    <div class="search-container">
        <h2>Search Quotes</h2>

        <form @submit.prevent="handleSearch" class="search-form">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by insurer, name, or car plate..."
                class="search-input"
            />
            <button type="submit" class="search-button" :disabled="isSearching">
                {{ isSearching ? 'Searching...' : 'Search' }}
            </button>
        </form>

        <div class="results-wrapper">
            <p v-if="isSearching" class="info-text">Searching database...</p>

            <div v-else-if="results.length > 0">
                <p class="results-count">Found {{ results.length }} matching quote(s):</p>
                <QuotesCard
                    v-for="quote in results"
                    :key="quote.id"
                    :quote="quote"
                    @quote-deleted="handleQuoteDeleted"
                />
            </div>

            <p v-else-if="hasSearched" class="info-text">No quotes matched your search query.</p>
        </div>
    </div>
</template>

<style scoped>
.search-container {
    background-color: #ffffff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    max-width: 450px;
    margin: 0 auto;
}

h2 {
    margin-top: 0;
    color: #0f172a;
}

.search-form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.search-input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 0.95rem;
}

.search-button {
    background-color: #2563eb;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

.search-button:disabled {
    background-color: #94a3b8;
}

.info-text {
    color: #64748b;
    text-align: center;
    margin-top: 20px;
}

.results-count {
    font-size: 0.85rem;
    color: #475569;
    margin-bottom: 12px;
}
</style>
