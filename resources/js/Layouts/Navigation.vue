<template>
    <nav>
        <ul>
            <li><Link href="/dashboard">Dashboard</Link></li>
            <li><Link href="/todo">To-Do List</Link></li> 
        </ul>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: { Link },
};
</script>
