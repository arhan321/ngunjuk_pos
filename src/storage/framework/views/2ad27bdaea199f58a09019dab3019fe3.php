<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
   'placeholder' => 'Search for anything ...',
   'maxlength' => 64
]));

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

foreach (array_filter(([
   'placeholder' => 'Search for anything ...',
   'maxlength' => 64
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $classes = [
        // base input styling 
        'block w-full border-none bg-transparent',
        
        // padding and text sizing - because size matters (in UI) 📏
        'pt-1.5 pb-2 text-base sm:text-sm sm:leading-6',
        
        // light mode colors 
        'text-gray-950 placeholder:text-gray-400',
        
        // dark mode colors 
        'dark:text-white dark:placeholder:text-gray-500',
        
        // focus states 
        'focus:ring-0 transition duration-75',

        // disabled states (light mode) 
        'disabled:text-gray-500 disabled:[-webkit-text-fill-color:var(--color-gray-500)]',
        'disabled:placeholder:[-webkit-text-fill-color:var(--color-gray-400)]',
        
        // disabled states (dark mode)
        'dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:var(--color-gray-400)]',
        'dark:disabled:placeholder:[-webkit-text-fill-color:var(--color-gray-500)]',
    ];
?>
<input
   id="search-input"
   type="search"
   aria-autocomplete="both"
   aria-labelledby="search-label"
   aria-activedescendant="search-item-0"
   aria-controls="search-list"
   
   style="border:none; outline:none"
   
   x-on:keydown.down.prevent.stop="$dispatch('focus-first-element')"
   wire:model.live.debounce.200ms="search"
   x-on:keydown.enter.prevent 
   
   autocomplete="off"
   autocorrect="off"
   x-data="{}"
   autocapitalize="none"
   enterkeyhint="go"
   spellcheck="false"
   placeholder="<?php echo e(__( $placeholder)); ?>"
   autofocus="true"
   maxlength="<?php echo e($maxlength); ?>"
   class="<?php echo e($attributes->class(Arr::toCssClasses($classes))); ?>"
/>
<?php /**PATH /var/www/html/vendor/charrafimed/global-search-modal/resources/views/components/search/input.blade.php ENDPATH**/ ?>