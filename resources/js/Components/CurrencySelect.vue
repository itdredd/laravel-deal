<template>
    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">{{ $t('currency.select_currency') }}</option>
        <option value="RUB">{{ $t('currency.rub') }}</option>
        <option value="UAH">{{ $t('currency.uah') }}</option>
        <option value="USD">{{ $t('currency.usd') }}</option>
    </select>
</template>

<script>
export default {
    name: "CurrencySelect"
}
</script>

<style scoped>

</style>
