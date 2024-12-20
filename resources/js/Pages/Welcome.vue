<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-900 to-black text-white flex flex-col">
        <!-- Header -->
        <header class="flex justify-between items-center p-6 bg-gray-800 shadow-md">
            <div class="text-lg font-bold tracking-wider text-blue-400">
                Tech Innovators
            </div>
            <nav v-if="canLogin" class="flex space-x-4">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="text-white px-4 py-2 rounded hover:bg-gray-700 hover:text-blue-300">
                Dashboard
                </Link>
                <template v-else>
                    <Link :href="route('login')"
                        class="text-white px-4 py-2 rounded hover:bg-gray-700 hover:text-blue-300">
                    Log in
                    </Link>
                    <Link v-if="canRegister" :href="route('register')"
                        class="text-white px-4 py-2 rounded hover:bg-gray-700 hover:text-blue-300">
                    Register
                    </Link>
                </template>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col justify-center items-center py-10">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold mb-4 text-blue-400 drop-shadow-lg">
                    Welcome to the Future
                </h1>
                <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                    Please login to use the Todo-List Application
                </p>
            </div>

            <!-- Topics Section -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 px-6 max-w-7xl mx-auto mt-10">
                <div v-for="topic in topics" :key="topic.title"
                    class="cursor-pointer p-6 bg-gray-800 hover:bg-gray-700 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-300">
                        {{ topic.title }}
                    </h2>
                    <p class="text-gray-400 mb-4">{{ topic.description }}</p>
                    <a :href="topic.link" @click="setTabTitle" target="_blank"
                        class="text-blue-500 hover:text-blue-400 underline">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Selected Topic Modal -->
            <div v-if="selectedTopic"
                class="mt-10 p-6 bg-gray-800 text-center rounded-lg mx-6 lg:mx-auto max-w-4xl border border-blue-400">
                <h3 class="text-3xl font-bold text-blue-300">
                    {{ selectedTopic.title }}
                </h3>
                <p class="text-gray-300 mt-4">{{ selectedTopic.description }}</p>
                <button @click="selectedTopic = null"
                    class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-400 transition-transform transform hover:scale-105">
                    Close
                </button>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-6 text-center text-gray-500 border-t border-gray-700">
            Built with Vue.js | © 2024 Billy Terante
        </footer>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
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

defineProps({
    canLogin: {
        type: Boolean,
        required: true,
    },
    canRegister: {
        type: Boolean,
        required: true,
    },
});

const topics = [
    {
        title: "Artificial Intelligence (AI)",
        description:
            "Explore the cutting-edge world of AI, from machine learning to natural language processing and generative AI.",
        link: "https://cloud.google.com/learn/what-is-artificial-intelligence",
    },
    {
        title: "Virtual Reality (VR)",
        description:
            "Dive into immersive experiences with VR, revolutionizing entertainment, training, and education.",
        link: "https://arvr.google.com/",
    },
    {
        title: "Augmented Reality (AR)",
        description:
            "Enhance the real world with AR technology, blending the digital with the physical.",
        link: "https://developers.google.com/ar",
    },
    {
        title: "Cryptography",
        description:
            "Secure your data with advanced cryptographic methods, ensuring privacy and integrity.",
        link: "https://www.ibm.com/topics/cryptography",
    },
];

const selectedTopic = ref(null);

function selectTopic(topic) {
    selectedTopic.value = topic;
}
</script>

<style scoped>
html {
    scroll-behavior: smooth;
}

h1 {
    font-family: "Poppins", sans-serif;
}

button {
    font-family: "Poppins", sans-serif;
}

a:hover {
    text-decoration: none;
}
</style>