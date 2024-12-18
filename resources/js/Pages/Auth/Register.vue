<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { onMounted, onBeforeUnmount } from "vue";

function handleVisibilityChange() {
    document.title = document.hidden ? "Laravel Is Cool With Vuejs" : "Laravel";
}

onMounted(() => {
    document.addEventListener("visibilitychange", handleVisibilityChange);
});

onBeforeUnmount(() => {
    document.removeEventListener("visibilitychange", handleVisibilityChange);
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

// Strong password validation pattern
const strongPasswordPattern =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,64}$/;

// Validate email format
const validateEmail = () => {
    form.email = form.email.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(form.email)) {
        form.errors.email = "Please enter a valid email address.";
    } else {
        form.errors.email = "";
    }
};

// Validate strong password
const validatePassword = () => {
    const password = form.password;

    if (!strongPasswordPattern.test(password)) {
        form.errors.password =
            "Password must be 8-64 characters long, include uppercase and lowercase letters, a number, and a special character.";
    } else {
        form.errors.password = "";
    }
};

// Ensure password confirmation matches
const validatePasswordConfirmation = () => {
    if (form.password !== form.password_confirmation) {
        form.errors.password_confirmation = "Passwords do not match.";
    } else {
        form.errors.password_confirmation = "";
    }
};

// Submit form with validation
const submit = () => {
    validateEmail();
    validatePassword();
    validatePasswordConfirmation();

    if (
        !form.errors.email &&
        !form.errors.password &&
        !form.errors.password_confirmation
    ) {
        form.post(route("register"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    }
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form
            @submit.prevent="submit"
            class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto"
        >
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

            <div class="mb-4">
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mb-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    @blur="validateEmail"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mb-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    @blur="validatePassword"
                    required
                    maxlength="64"
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mb-6">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    @blur="validatePasswordConfirmation"
                    required
                    maxlength="64"
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 text-center">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>

            <div class="mt-4 text-center">
                <span class="text-gray-600">Already have an account?</span>
                <Link
                    :href="route('login')"
                    class="text-indigo-600 hover:underline ml-1"
                >
                    Login Here
                </Link>
            </div>
        </form>
        <!-- Button to Welcome Page -->
        <div class="mt-4 text-center">
            <button
                @click="$inertia.visit('/')"
                class="w-full flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500"
            >
                Go to Welcome Page
            </button>
        </div>
    </GuestLayout>
</template>

<style scoped>
form {
    background: #f9f9f9;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
}

input {
    border: 1px solid #ccc;
    padding: 0.5rem;
    border-radius: 5px;
    width: 100%;
}

input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 5px rgba(99, 102, 241, 0.5);
}

button {
    background-color: #6366f1;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 5px;
}

button:hover {
    background-color: #4f46e5;
}
</style>
