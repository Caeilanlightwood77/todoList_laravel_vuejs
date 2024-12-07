<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { onMounted, onBeforeUnmount } from "vue";

function handleVisibilityChange() {
    if (document.hidden) {
        document.title = "Laravel Is Cool With Vuejs";
    } else {
        document.title = "Laravel";
    }
}

onMounted(() => {
    document.addEventListener("visibilitychange", handleVisibilityChange);
});

onBeforeUnmount(() => {
    document.removeEventListener("visibilitychange", handleVisibilityChange);
});

// Define props for password reset and status message
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Form setup
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

// Submit function for regular login
const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

// Redirect to Google OAuth
const redirectToGoogle = () => {
    window.location.href = "/auth/google/redirect";
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <!-- Card Container -->
        <div class="w-full max-w-md bg-white rounded-lg p-4">
            <!-- Header -->
            <h1 class="text-xl font-bold text-center text-gray-800">
                Welcome Back
            </h1>

            <!-- Status Message -->
            <div v-if="status" class="mt-2 text-center text-sm text-green-600">
                {{ status }}
            </div>

            <!-- Login Form -->
            <form @submit.prevent="submit" class="mt-4 space-y-3">
                <!-- Email and Password Inputs (Inline) -->
                <div class="flex flex-col gap-3">
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between mt-2">
                    <label class="flex items-center text-sm text-gray-600">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ml-2">Remember me</span>
                    </label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-indigo-600 hover:underline"
                    >
                        Forgot password?
                    </Link>
                </div>

                <!-- Submit Button -->
                <div>
                    <PrimaryButton
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                        class="w-full flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        Log In
                    </PrimaryButton>
                </div>
            </form>

            <!-- Google Login -->
            <div class="mt-3">
                <button
                    @click="redirectToGoogle"
                    type="button"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-500 text-white font-medium rounded-md shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 48 48"
                        class="w-5 h-5"
                    >
                        <path
                            fill="#EA4335"
                            d="M24 9.5c3.54 0 6.76 1.18 9.32 3.18l7.11-7.11C36.97 2.27 30.87 0 24 0 14.93 0 6.89 4.98 2.69 12.36l8.52 6.63C13.36 13.27 18.38 9.5 24 9.5z"
                        />
                        <path
                            fill="#34A853"
                            d="M46.67 24c0-1.34-.12-2.64-.34-3.89H24v7.38h13c-.56 3.01-2.27 5.56-4.87 7.29l7.53 5.87C44.58 36.54 46.67 30.75 46.67 24z"
                        />
                        <path
                            fill="#4A90E2"
                            d="M9.69 27.2c-.56-1.68-.88-3.47-.88-5.2s.32-3.52.88-5.2L1.17 9.83C-.57 13.11-1.33 16.48-1.33 20s.76 6.89 2.5 10.17l8.52-6.63z"
                        />
                        <path
                            fill="#FBBC05"
                            d="M24 48c6.87 0 12.97-2.27 17.82-6.08l-8.52-6.63C30.76 37.96 27.54 39 24 39c-5.62 0-10.64-3.77-12.79-9.29l-8.52 6.63C6.89 43.02 14.93 48 24 48z"
                        />
                    </svg>
                    Continue with Google
                </button>
            </div>
        </div>
    </GuestLayout>
</template>
