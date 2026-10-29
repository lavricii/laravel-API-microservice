<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

let route;
let router;
try {
    route = useRoute();
    router = useRouter();
} catch (e) {
    route = null;
    router = null;
}

const getIdentifier = () => {
    if (route && route.params && (route.params.identifier || route.params.plate || route.params.id)) {
        return route.params.identifier || route.params.plate || route.params.id;
    }
    const pathParts = window.location.pathname.split('/').filter(Boolean);
    return pathParts[pathParts.length - 1] || '';
};

const identifier = getIdentifier();

const form = ref({
    client_name: '',
    car_plate: '',
    asigurator: '',
    price: ''
});

const statusMessage = ref('');
const isError = ref(false);
const loading = ref(false);
const fetching = ref(true);

onMounted(async () => {
    if (!identifier) {
        isError.value = true;
        statusMessage.value = 'No quote identifier provided in URL.';
        fetching.value = false;
        return;
    }

    try {
        const response = await fetch(`/api/quote/${identifier}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Quote not found');
        }

        const quote = data.data || data;
        form.value = {
            client_name: quote.client_name || '',
            car_plate: quote.car_plate || '',
            asigurator: quote.asigurator || quote.insurer_name || '',
            price: quote.price !== undefined ? quote.price : ''
        };
    } catch (err) {
        isError.value = true;
        statusMessage.value = err.message;
    } finally {
        fetching.value = false;
    }
});

const submitForm = async () => {
    statusMessage.value = '';
    isError.value = false;
    loading.value = true;

    try {
        const response = await fetch(`/api/quote/${identifier}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                client_name: form.value.client_name,
                car_plate: form.value.car_plate,
                asigurator: form.value.asigurator,
                price: parseFloat(form.value.price)
            })
        });

        const data = await response.json();

        if (!response.ok) {
            const errs = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Failed to update');
            throw new Error(errs);
        }

        isError.value = false;
        statusMessage.value = 'Quote updated successfully! Redirecting...';

        setTimeout(() => {
            if (router) {
                router.push('/');
            } else {
                window.location.href = '/';
            }
        }, 1000);

    } catch (err) {
        isError.value = true;
        statusMessage.value = err.message;
        loading.value = false;
    }
};
</script>

<template>
    <div style="max-width: 540px; margin: 40px auto; padding: 28px; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 24px;">Edit Existing Quote</h2>

        <div v-if="statusMessage" :style="{
      padding: '12px 16px',
      borderRadius: '8px',
      marginBottom: '20px',
      fontSize: '14px',
      fontWeight: '500',
      background: isError ? '#fee2e2' : '#dcfce7',
      color: isError ? '#991b1b' : '#166534',
      border: isError ? '1px solid #f87171' : '1px solid #86efac'
    }">
            {{ statusMessage }}
        </div>

        <div v-if="fetching" style="text-align: center; padding: 20px; color: #64748b; font-size: 14px;">
            Loading quote details...
        </div>

        <form v-else @submit.prevent="submitForm" style="display: flex; flex-direction: column; gap: 18px;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label style="font-size: 14px; font-weight: 600; color: #334155;">Client Name</label>
                    <span style="font-size: 12px; color: #94a3b8; font-weight: 500;">🔒 Non-editable</span>
                </div>
                <input
                    v-model="form.client_name"
                    type="text"
                    readonly
                    tabindex="-1"
                    style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; box-sizing: border-box; background-color: #f1f5f9; color: #64748b; cursor: not-allowed;"
                />
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">Car Plate</label>
                <input
                    v-model="form.car_plate"
                    type="text"
                    required
                    style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; background-color: #ffffff; color: #0f172a;"
                />
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">Insurer Name</label>
                <input
                    v-model="form.asigurator"
                    type="text"
                    required
                    style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; background-color: #ffffff; color: #0f172a;"
                />
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">Price (RON)</label>
                <input
                    v-model="form.price"
                    type="number"
                    step="0.01"
                    required
                    style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; background-color: #ffffff; color: #0f172a;"
                />
            </div>

            <button
                type="submit"
                :disabled="loading"
                style="margin-top: 10px; padding: 12px 20px; background-color: #2563eb; color: #ffffff; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; font-size: 15px; transition: background 0.2s ease;"
            >
                {{ loading ? 'Updating...' : 'Update Quote' }}
            </button>
        </form>
    </div>
</template>
