<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['actions']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['actions']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $shouldAssociateGroups = $this->getConfigs()->shouldAssociateGroups();
?>
<li
    <?php echo e($attributes); ?>

    class="fi-global-search-result my-1 mr-1 flex scroll-mt-9 items-center justify-between rounded-lg px-3 py-4 transition-colors duration-300 focus:bg-gray-100 hover:bg-gray-100/90 dark:bg-white/5 dark:focus:bg-white/10 dark:hover:bg-white/10"
    >
    <a 
        class="fi-global-search-result-link f outline-none"
        x-bind:href="result.url"
        x-on:click.stop="
            let targetUrl = result.url;
            let targetItem = result.title;
            let targetGroup = result.group;
            window.addEventListener('beforeunload', () => {
                addToSearchHistory(targetItem, targetGroup, targetUrl);
            }, { once: true });
        "
        x-on:keydown.enter.stop="$data.close()"
    >

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($shouldAssociateGroups): ?>
            <span
                class="rounded-xl   text-start flex max-w-fit bg-gray-100 px-4  text-gray-950/50 dark:bg-white/10 dark:text-white "
                x-text="result.group">
            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <h4 class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'text-sm text-start font-medium text-gray-950 dark:text-white',
        ]); ?>">
            <?php echo e($slot); ?>

        </h4>
    </a>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($actions)): ?>
        <span class="actions-wrapper flex items-center">
            <?php echo e($actions); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</li>
<?php /**PATH /var/www/html/vendor/charrafimed/global-search-modal/resources/views/components/search/summary/item.blade.php ENDPATH**/ ?>