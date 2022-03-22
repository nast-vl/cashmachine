<template>
    <div class="ui error message" style="display: inherit;">
        <i class="close icon" @click="$emit('dismiss')"></i>
        <div class="header">
            There were some errors with your submission
        </div>
        <ul class="list">
            <li v-for="message in messages">{{ message }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'ValidationMessagesComponent',
        props: ['errors'],
        computed: {
            messages() {
                return Object.values(this.errors).reduce((accumulator, current) => accumulator.concat(current), []);
            }
        }
    }
</script>
