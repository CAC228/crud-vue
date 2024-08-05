<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["users"]);
const emit = defineEmits(["data-changed"]);

const isEditing = ref(false);

const form = useForm({
    id: null,
    name: "",
    birtdate: "",
    phonenumber: "",
    email: "",
    login: "",
    password: "",
    photo: null,
});

function submitForm() {
    if (isEditing.value) {
        form.put(route("users.update", form.id), {
            onSuccess: () => {
                form.reset();
                isEditing.value = false;
                emit("data-changed");
            },
        });
    } else {
        form.post(route("users.store"), {
            onSuccess: () => {
                form.reset();
                emit("data-changed");
            },
        });
    }
}

function editUser(user) {
    form.id = user.id;
    form.name = user.name;
    form.phonenumber = user.phonenumber;
    form.login = user.login;
    form.email = user.email;
    form.password = "";
    form.photo = null;

    isEditing.value = true;
}

function cancelEdit() {
    form.reset();
    isEditing.value = false;
}

function deleteUser(id) {
    form.delete(route("users.destroy", id), {
        onSuccess: () => {
            form.reset();
            emit("data-changed");
        },
    });
}
</script>
<template>
    <div>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div class="flex space-x-4">
                <input
                    v-model="form.name"
                    placeholder="Имя"
                    class="border rounded p-2 w-full"
                />
                <input
                    v-model="form.birtdate"
                    placeholder="Дата Рождения"
                    class="border rounded p-2 w-full"
                    type="date"
                />
                <input
                    v-model="form.email"
                    placeholder="Email"
                    class="border rounded p-2 w-full"
                />
                <input
                    v-model="form.phonenumber"
                    placeholder="Номер телефона"
                    class="border rounded p-2 w-full"
                />
                <input
                    v-model="form.login"
                    placeholder="Логин"
                    class="border rounded p-2 w-full"
                />
                <input
                    v-if="!isEditing"
                    v-model="form.password"
                    placeholder="Пароль"
                    class="border rounded p-2 w-full"
                    type="password"
                />
                <button
                    type="submit"
                    class="bg-blue-500 text-white p-2 rounded"
                >
                    {{ isEditing ? "Обновить" : "Добавить" }}
                </button>
                <button
                    v-if="isEditing"
                    @click="cancelEdit"
                    class="bg-gray-500 text-white p-2 rounded"
                >
                    Отменить
                </button>
            </div>
        </form>
        <ul class="mt-4 space-y-2">
            <li
                v-for="user in users"
                :key="user.id"
                class="flex justify-between items-center p-2 border rounded"
            >
                <span>{{ user.name || "-" }} - {{ user.email || "-" }} </span>
                <div>
                    <button
                        @click="editUser(user)"
                        class="bg-yellow-500 text-white p-1 rounded ml-2"
                    >
                        Редактировать
                    </button>
                    <button
                        @click="deleteUser(user.id)"
                        class="bg-red-500 text-white p-1 rounded ml-2"
                    >
                        Удалить
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.flex {
    display: flex;
    gap: 10px;
}
.space-x-4 {
    gap: 16px;
}
.space-y-4 > * + * {
    margin-top: 16px;
}
.space-y-2 > * + * {
    margin-top: 8px;
}
</style>
