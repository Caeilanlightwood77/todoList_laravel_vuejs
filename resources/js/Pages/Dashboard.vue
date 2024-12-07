<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { onMounted, onBeforeUnmount } from "vue";

function handleVisibilityChange() {
    if (document.hidden) {
        document.title = "Laravel Is Cool With Vuejs";
    } else {
        document.title = "Laravel - Dashboard";
    }
}

onMounted(() => {
    document.addEventListener("visibilitychange", handleVisibilityChange);
});

onBeforeUnmount(() => {
    document.removeEventListener("visibilitychange", handleVisibilityChange);
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-black">
                Dashboard
            </h2>
        </template>

        <div class="py-12 bg-gray-100">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Welcome Card -->
                <div
                    class="overflow-hidden bg-white dark:bg-gray-800 shadow-md sm:rounded-lg"
                >
                    <div class="p-6">
                        <h3
                            class="text-lg font-semibold text-gray-800 dark:text-gray-100"
                        >
                            Welcome, {{ $page.props.auth.user.name }}!
                        </h3>
                        <p
                            class="mt-2 text-sm text-gray-600 dark:text-gray-400"
                        >
                            This is your personal dashboard where you can manage
                            your tasks and profile settings.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <!-- To-Do List Card -->
                    <div
                        class="bg-blue-500 text-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow"
                    >
                        <h4 class="text-lg font-semibold">To-Do List</h4>
                        <p class="mt-2 text-sm">
                            Manage your tasks efficiently and stay organized.
                        </p>
                        <Link href="/todo">
                            <button
                                class="mt-4 px-4 py-2 bg-white text-blue-500 font-semibold rounded-lg shadow-md hover:bg-gray-100"
                            >
                                Open To-Do List
                            </button>
                        </Link>
                    </div>

                    <!-- Profile Settings Card -->
                    <div
                        class="bg-gray-800 text-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow"
                    >
                        <h4 class="text-lg font-semibold">Profile Settings</h4>
                        <p class="mt-2 text-sm">
                            Update your profile information and change your
                            password.
                        </p>
                        <Link href="/profile">
                            <button
                                class="mt-4 px-4 py-2 bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600"
                            >
                                Edit Profile
                            </button>
                        </Link>
                    </div>

                    <!-- Additional Feature Card -->
                    <div
                        class="bg-green-500 text-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow"
                    >
                        <h4 class="text-lg font-semibold">New Feature</h4>
                        <p class="mt-2 text-sm">
                            Explore the latest features and tools available to
                            you.
                        </p>
                        <button
                            class="mt-4 px-4 py-2 bg-white text-green-500 font-semibold rounded-lg shadow-md hover:bg-gray-100"
                        >
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
