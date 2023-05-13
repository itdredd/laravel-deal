<template>
    <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <option value="">{{ $t('form.select_x', {'x': $t('deal.status').toLowerCase()}) }}</option>
        <option value="closed">{{ $t('deal.status.closed') }}</option>
        <option value="arbitration">{{ $t('deal.status.on_arbitration') }}</option>
        <option value="open">{{ $t('deal.status.open') }}</option>
        <option value="awaiting">{{ $t('deal.status.awaiting') }}</option>
        <option value="rejected">{{ $t('deal.status.rejected') }}</option>
    </select>
</template>

<script setup>
</script>

<style scoped>
</style>
