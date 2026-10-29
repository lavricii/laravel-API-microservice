<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
    client_name: '',
    car_plate: '',
    asigurator: '',
    price: ''
})

const isSubmitting = ref(false)
const errorMessage = ref('')

const submitForm = async () => {
    isSubmitting.value = true
    errorMessage.value = ''

    try {
        const response = await fetch('/api/quote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(form.value)
        })

        const data = await response.json()

        if (!response.ok) {
            // Show field validation errors if available, otherwise hide raw code errors with a friendly message
            if (data.errors) {
                const firstErrorKey = Object.keys(data.errors)[0]
                throw new Error(data.errors[firstErrorKey][0])
            }
            throw new Error('Failed to create quote. Please check your inputs and try again.')
        }

        router.push('/')
    } catch (error) {
        console.error('Error creating quote:', error)
        // Always fallback to a clean user message instead of raw SQL dumps
        errorMessage.value = error.message.includes('SQLSTATE')
            ? 'An error occurred while saving the quote. Please try again.'
            : error.message
    } finally {
        isSubmitting.value = false
    }
}
</script>

<template>
    <div class="form-container">
        <h2>Create New Quote</h2>

        <div v-if="errorMessage" class="error-banner">
            {{ errorMessage }}
        </div>

        <form @submit.prevent="submitForm" class="quote-form">
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input
                    id="client_name"
                    v-model="form.client_name"
                    type="text"
                    placeholder="e.g. John Doe"
                    required
                />
            </div>

            <div class="form-group">
                <label for="car_plate">Car Plate</label>
                <input
                    id="car_plate"
                    v-model="form.car_plate"
                    type="text"
                    placeholder="e.g. B18ANI"
                    required
                />
            </div>

            <div class="form-group">
                <label for="asigurator">Insurer (Asigurator)</label>
                <input
                    id="asigurator"
                    v-model="form.asigurator"
                    type="text"
                    placeholder="e.g. Groupama"
                    required
                />
            </div>

            <div class="form-group">
                <label for="price">Price (RON)</label>
                <input
                    id="price"
                    v-model.number="form.price"
                    type="number"
                    step="0.01"
                    placeholder="e.g. 450.00"
                    required
                />
            </div>

            <button type="submit" class="submit-btn" :disabled="isSubmitting">
                {{ isSubmitting ? 'Saving...' : 'Create Quote' }}
            </button>
        </form>
    </div>
</template>

<style scoped>
.form-container {
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
    margin-bottom: 20px;
}

.error-banner {
    background-color: #fef2f2;
    color: #dc2626;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 16px;
    font-size: 0.9rem;
}

.quote-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
}

input {
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 0.95rem;
}

input:focus {
    outline: 2px solid #2563eb;
    border-color: transparent;
}

.submit-btn {
    background-color: #16a34a;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
}

.submit-btn:disabled {
    background-color: #86efac;
}
</style>
