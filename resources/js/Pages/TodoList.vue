<template>
    <div :class="darkMode
        ? 'dark bg-gray-900 text-gray-100'
        : 'bg-gray-100 text-gray-900'
        " class="min-h-screen py-12">
        <div class="container mx-auto max-w-4xl bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    To-Do List
                </h1>
                <div class="flex items-center gap-4">
                    <button @click="toggleDarkMode"
                        class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 dark:bg-gray-400 dark:hover:bg-gray-600">
                        {{ darkMode ? "Light Mode" : "Dark Mode" }}
                    </button>
                    <Link href="/dashboard">
                    <button
                        class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none">
                        Back to Dashboard
                    </button>
                    </Link>
                </div>
            </div>

            <!-- Add Task Section -->
            <div class="px-6 py-4">
                <form @submit.prevent="addTask" class="flex gap-2">
                    <input v-model="newTask" type="text" placeholder="Enter a new task"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none">
                        Add Task
                    </button>
                </form>
            </div>

            <!-- Search, Sort, and Filter Section -->
            <div class="px-6 py-4 flex flex-col md:flex-row gap-4 justify-between">
                <input v-model="searchQuery" type="text" placeholder="Search tasks..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />

                <select v-model="sortOrder"
                    class="px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    <option value="asc">Sort A-Z</option>
                    <option value="desc">Sort Z-A</option>
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>

                <select v-model="statusFilter"
                    class="px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    <option value="all">All Tasks</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <!-- Task List -->
            <div class="px-6 py-4">
                <ul class="space-y-3">
                    <li v-for="task in filteredTasks" :key="task.id"
                        class="flex items-center justify-between p-4 rounded-lg shadow-sm" :class="task.status === 'completed'
                            ? 'bg-green-200 dark:bg-green-700'
                            : 'bg-gray-50 dark:bg-gray-700'
                            ">
                        <div class="flex-1">
                            <input v-if="editingTaskId === task.id" v-model="editedTaskTitle"
                                @keyup.enter="updateTask(task.id)"
                                class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-200 focus:outline-none dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" />
                            <span v-else class="text-gray-700 dark:text-gray-300" :class="{
                                'line-through': task.status === 'completed',
                            }">
                                {{ task.title }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Mark as Completed Button -->
                            <button @click="toggleTaskStatus(task)" class="px-3 py-1 text-sm rounded-lg shadow-md"
                                :class="task.status === 'completed'
                                    ? 'bg-gray-500 text-white hover:bg-gray-700'
                                    : 'bg-green-500 text-white hover:bg-green-700'
                                    ">
                                {{
                                    task.status === "completed"
                                        ? "Mark Pending"
                                        : "Mark Completed"
                                }}
                            </button>

                            <button v-if="editingTaskId !== task.id" @click="startEdit(task)"
                                class="px-3 py-1 text-sm bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-700 focus:outline-none">
                                Edit
                            </button>
                            <button v-else @click="updateTask(task.id)"
                                class="px-3 py-1 text-sm bg-green-500 text-white rounded-lg shadow-md hover:bg-green-700 focus:outline-none">
                                Save
                            </button>
                            <button @click="confirmDeleteTask(task.id)"
                                class="px-3 py-1 text-sm bg-red-500 text-white rounded-lg shadow-md hover:bg-red-700 focus:outline-none">
                                Delete
                            </button>
                        </div>
                    </li>
                </ul>
                <div v-if="filteredTasks.length === 0" class="mt-4 text-center text-gray-600 dark:text-gray-400">
                    No tasks found. Start by adding a task!
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="taskToDelete" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 w-96">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Confirm Deletion
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete this task? Enter "DELETE" to
                    confirm.
                </p>
                <input v-model="confirmationText" type="text" placeholder="Type DELETE to confirm"
                    class="mt-4 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-red-200 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
                <div class="mt-4 flex gap-2">
                    <button @click="deleteTask(taskToDelete)" :disabled="confirmationText !== 'DELETE'"
                        class="flex-1 px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none disabled:opacity-50">
                        Confirm
                    </button>
                    <button @click="cancelDelete"
                        class="flex-1 px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { Link } from "@inertiajs/vue3";

export default {
    components: { Link },
    data() {
        return {
            tasks: [],
            newTask: "",
            darkMode: false,
            taskToDelete: null,
            confirmationText: "",
            editingTaskId: null,
            editedTaskTitle: "",
            searchQuery: "",
            sortOrder: "asc",
            statusFilter: "all",
        };
    },
    mounted() {
        this.fetchTasks();
        this.loadDarkModePreference();
    },
    computed: {
        filteredTasks() {
            return this.tasks
                .filter((task) => {
                    const titleMatches = task.title
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase());

                    const statusMatches =
                        this.statusFilter === "all" ||
                        task.status.toLowerCase() === this.statusFilter.toLowerCase();

                    return titleMatches && statusMatches;
                })
                .sort((a, b) => {
                    if (this.sortOrder === "asc")
                        return a.title.localeCompare(b.title);
                    if (this.sortOrder === "desc")
                        return b.title.localeCompare(a.title);
                    if (this.sortOrder === "newest")
                        return new Date(b.created_at) - new Date(a.created_at);
                    if (this.sortOrder === "oldest")
                        return new Date(a.created_at) - new Date(b.created_at);
                    return 0;
                });
        },
    },
    methods: {
        async fetchTasks() {
            try {
                const response = await axios.get("/api/tasks");
                this.tasks = response.data;
            } catch (error) {
                console.error("Error fetching tasks:", error);
            }
        },
        async addTask() {
            if (!this.newTask.trim()) return;
            try {
                const response = await axios.post("/api/tasks", {
                    title: this.newTask,
                    status: "pending",
                });
                this.tasks.push(response.data);
                this.newTask = "";
            } catch (error) {
                console.error("Error adding task:", error);
            }
        },
        async toggleTaskStatus(task) {
            const newStatus =
                task.status === "completed" ? "pending" : "completed";
            try {
                await axios.put(`/api/tasks/${task.id}`, { status: newStatus });
                task.status = newStatus;
            } catch (error) {
                console.error("Error updating task status:", error);
            }
        },
        startEdit(task) {
            this.editingTaskId = task.id;
            this.editedTaskTitle = task.title;
        },
        async updateTask(taskId) {
            if (!this.editedTaskTitle.trim()) return;
            try {
                await axios.put(`/api/tasks/${taskId}`, {
                    title: this.editedTaskTitle,
                });
                const task = this.tasks.find((t) => t.id === taskId);
                if (task) task.title = this.editedTaskTitle;
                this.editingTaskId = null;
                this.editedTaskTitle = "";
            } catch (error) {
                console.error("Error updating task:", error);
            }
        },
        confirmDeleteTask(taskId) {
            this.taskToDelete = taskId;
            this.confirmationText = "";
        },
        cancelDelete() {
            this.taskToDelete = null;
            this.confirmationText = "";
        },
        async deleteTask(taskId) {
            try {
                await axios.delete(`/api/tasks/${taskId}`);
                this.tasks = this.tasks.filter((task) => task.id !== taskId);
                this.taskToDelete = null;
            } catch (error) {
                console.error("Error deleting task:", error);
            }
        },
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem("darkMode", this.darkMode);
        },
        loadDarkModePreference() {
            this.darkMode = localStorage.getItem("darkMode") === "true";
        },
    },
};
</script>
