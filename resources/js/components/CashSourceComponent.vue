<template>
    <div>
        <form class="ui small form" action="/machine/cash" @submit.prevent="onSubmit()">
            <div class="field">
                <label>Banknote of 1</label>
                <input type="number" name="banknote_of_1" min="0" pattern="[0-9]" value="0">
            </div>
            <div class="field">
                <label>Banknote of 5</label>
                <input type="number" name="banknote_of_5" min="0" pattern="[0-9]" value="0">
            </div>
            <div class="field">
                <label>Banknote of 10</label>
                <input type="number" name="banknote_of_10" min="0" pattern="[0-9]" value="0">
            </div>
            <div class="field">
                <label>Banknote of 50</label>
                <input type="number" name="banknote_of_50" min="0" pattern="[0-9]" value="0">
            </div>
            <div class="field">
                <label>Banknote of 100</label>
                <input type="number" name="banknote_of_100" min="0" pattern="[0-9]" value="0">
            </div>
            <div class="ui basic center aligned segment">
                <button class="ui button" type="submit">Submit</button>
            </div>
            <validation-messages-component v-if="hasErrors" :errors="errors" @dismiss="flushErrors()"></validation-messages-component>
        </form>
    </div>
</template>

<script>
    import SubmitsFormMixin from './SubmitsFormMixin';

    export default {
        name: 'CashSourceComponent',
        mixins: [SubmitsFormMixin]
    }
</script>
