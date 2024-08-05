<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Users from "@/Components/Admin/Users.vue";

const props = defineProps("users");
const users = ref("users");
const loading = ref(false);
async function fetchData() {
    loading.value = true;
    try {
        const response = await axios.get(route("users.index"));
        users.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}
onMounted(async () => {
    await fetchData();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Users :users="users" @data-changed="fetchData" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
