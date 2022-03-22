<template>
    <div>
        <div class="ui fluid small steps">
            <div class="link step" :class="{'active': active === 'cash'}" @click="active = 'cash'">
                <i class="money bill wave icon"></i>
                <div class="content">
                    <div class="title">Cash</div>
                    <div class="description">Choose cash source option</div>
                </div>
            </div>
            <div class="link step" :class="{'active': active === 'credit_card'}" @click="active = 'credit_card'">
                <i class="credit card icon"></i>
                <div class="content">
                    <div class="title">Credit Card</div>
                    <div class="description">Choose credit card source option</div>
                </div>
            </div>
            <div class="link step" :class="{'active': active === 'bank_transfer'}" @click="active = 'bank_transfer'">
                <i class="money check alternate icon"></i>
                <div class="content">
                    <div class="title">Bank Transfer</div>
                    <div class="description">Choose bank transfer source option</div>
                </div>
            </div>
        </div>
        <div class="ui container grid">
            <div class="sixteen wide column">
                <cash-source-component v-if="active === 'cash'"></cash-source-component>
                <credit-card-source-component v-if="active === 'credit_card'"></credit-card-source-component>
                <bank-transfer-source-component v-if="active === 'bank_transfer'"></bank-transfer-source-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SourceManagerComponent',
        data() {
            return {
                active: 'cash'
            }
        }
    }
</script>
