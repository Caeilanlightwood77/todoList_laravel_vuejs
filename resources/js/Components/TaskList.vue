<template>
    <div>
        <h1>To-Do List</h1>
        <form @submit.prevent="addTask">
            <input v-model="newTask" placeholder="New Task" />
            <button type="submit">Add</button>
        </form>

        <ul>
            <li v-for="task in tasks" :key="task.id">
                <span v-if="editingTaskId !== task.id">{{ task.title }}</span>
                <input v-else v-model="editedTaskTitle" @keyup.enter="updateTask(task.id)" />

                <button v-if="editingTaskId !== task.id" @click="startEditing(task.id, task.title)">Edit</button>
                <button v-else @click="updateTask(task.id)">Save</button>

                <button @click="deleteTask(task.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            tasks: [],
            newTask: '',
            editingTaskId: null,
            editedTaskTitle: '',
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        async fetchTasks() {
            const response = await axios.get('/api/tasks');
            this.tasks = response.data;
        },
        async addTask() {
            if (!this.newTask.trim()) return;
            const response = await axios.post('/api/tasks', { title: this.newTask });
            this.tasks.push(response.data);
            this.newTask = '';
        },
        async deleteTask(taskId) {
            await axios.delete(`/api/tasks/${taskId}`);
            this.tasks = this.tasks.filter(task => task.id !== taskId);
        },
        startEditing(taskId, currentTitle) {
            this.editingTaskId = taskId;
            this.editedTaskTitle = currentTitle;
        },
        async updateTask(taskId) {
            try {
                await axios.put(`/api/tasks/${taskId}`, { title: this.editedTaskTitle });
                const task = this.tasks.find(t => t.id === taskId);
                if (task) task.title = this.editedTaskTitle;
                this.editingTaskId = null;
                this.editedTaskTitle = '';
            } catch (error) {
                console.error("Error updating task:", error);
            }
        },
    },
};
</script>
