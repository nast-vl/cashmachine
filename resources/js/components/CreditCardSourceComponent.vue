<template>
    <form class="ui small form" action="/machine/creditCard" @submit.prevent="onSubmit()">
        <div class="field">
            <label>Card Number</label>
            <input type="text" name="card_number">
        </div>
        <div class="field">
            <label>Card Expiration</label>
            <input type="text" name="card_expiration" placeholder="MM/YYYY">
        </div>
        <div class="field">
            <label>Card Holder</label>
            <input type="text" name="card_holder">
        </div>
        <div class="field">
            <label>CVV</label>
            <input type="text" name="card_cvv">
        </div>
        <div class="field">
            <label>Amount</label>
            <input type="number" name="amount" min="0" step="any" value="0">
        </div>
        <div class="ui basic center aligned segment">
            <button class="ui button" type="submit">Submit</button>
        </div>
        <validation-messages-component v-if="hasErrors" :errors="errors" @dismiss="flushErrors()"></validation-messages-component>
    </form>
</template>

<script>
    import SubmitsFormMixin from './SubmitsFormMixin';

    export default {
        name: 'CreditCardSourceComponent',
        mixins: [SubmitsFormMixin]
    }
</script>
