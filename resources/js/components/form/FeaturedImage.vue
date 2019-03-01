<template>
    <div class="flex flex-col w-1/4 mb-8">
        <label for="file" class="text-base text-blue uppercase whitespace-no-wrap mr-2 mb-2">{{ fileLabel }}: </label>
        <input type="file" name="file" ref="file" @change="setFile()" class="w-300p"/>
    </div>
</template>

<script>
    export default {
        props: ['file-label', 'value'],
        methods: {
            setFile () {
                const file = this.$refs.file.files[0];
                this.$emit('input', file);
            }
        }
    }
</script>