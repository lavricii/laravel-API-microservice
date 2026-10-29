<script setup>
import { useRouter } from 'vue-router'

const props = defineProps({
    quote: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['quote-deleted'])

const router = useRouter()

const navigateToEdit = () => {
    router.push(`/edit/${props.quote.car_plate}`)
}

const handleDelete = async () => {
    if (!confirm(`Are you sure you want to delete quote for ${props.quote.car_plate}?`)) {
        return
    }

    try {
        const response = await fetch(`/api/quote/${props.quote.id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json'
            }
        })

        if (response.ok) {
            emit('quote-deleted', props.quote.id)
        } else {
            alert('Failed to delete quote.')
        }
    } catch (error) {
        console.error('Delete error:', error)
    }
}
</script>

<template>
    <div class="card">
        <div class="card-details">
            <div class="info-group">
                <span class="label">Client</span>
                <span class="value">{{ quote.client_name }}</span>
            </div>

            <div class="info-group">
                <span class="label">Car Plate</span>
                <span class="value plate">{{ quote.car_plate }}</span>
            </div>

            <div class="info-group">
                <span class="label">Insurer</span>
                <span class="value">{{ quote.asigurator }}</span>
            </div>

            <div class="info-group">
                <span class="label">Price</span>
                <span class="value price">{{ quote.price }} RON</span>
            </div>
        </div>

        <div class="card-actions">
            <button @click="navigateToEdit" class="btn btn-edit">Edit</button>
            <button @click="handleDelete" class="btn btn-delete">Delete</button>
        </div>
    </div>
</template>

<style scoped>
.card {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 12px;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    flex: 1;
}

.info-group {
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
}

.value {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.95rem;
}

.plate {
    color: #2563eb;
}

.price {
    color: #059669;
}

.card-actions {
    display: flex;
    gap: 8px;
    margin-left: 12px;
}

.btn {
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}

.btn-edit {
    background-color: #f59e0b;
    color: white;
}

.btn-delete {
    background-color: #ef4444;
    color: white;
}
</style>
