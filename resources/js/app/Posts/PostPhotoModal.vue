<template>
    <div class="bg-white p-4 rounded-lg">
        <img :src="photoUrl"/>
    </div>
</template>

<script>
    export default {
        props: ['photoUrl'],
    }
</script>