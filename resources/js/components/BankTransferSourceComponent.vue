<template>
    <form class="ui small form" action="/machine/bankTransfer" @submit.prevent="onSubmit()">
        <div class="field">
            <label>Transfer date</label>
            <input type="date" name="transfer_date">
        </div>
        <div class="field">
            <label>Customer Name</label>
            <input type="text" name="customer_name">
        </div>
        <div class="field">
            <label>Account Number</label>
            <input type="text" name="account_number">
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
        name: 'BankTransferSourceComponent',
        mixins: [SubmitsFormMixin]
    }
</script>
