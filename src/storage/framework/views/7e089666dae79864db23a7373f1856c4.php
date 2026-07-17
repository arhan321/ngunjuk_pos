<form 
    class="relative grid grid-cols-[auto_1fr] w-full items-center border-b border-gray-100 dark:border-gray-700 px-1 pt-0.5 pb-1.5"
>
    <label 
        class="flex min-w-[1.5rem] pr-2 items-center justify-center text-gray-300/40 dark:text-white/30"
        id="search-label" 
        for="search-input"
    >
        <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => \Filament\Support\Icons\Heroicon::MagnifyingGlass,'class' => 'fi-size-lg transition-all','wire:loading.class' => 'hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Icons\Heroicon::MagnifyingGlass),'class' => 'fi-size-lg transition-all','wire:loading.class' => 'hidden']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalbef7c2371a870b1887ec3741fe311a10 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbef7c2371a870b1887ec3741fe311a10 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.loading-indicator','data' => ['class' => 'fi-size-lg hidden transition-all','wire:loading.class.remove' => 'hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'fi-size-lg hidden transition-all','wire:loading.class.remove' => 'hidden']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $attributes = $__attributesOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $component = $__componentOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__componentOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>
    </label>
    
    <?php if (isset($component)) { $__componentOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'global-search-modal::components.search.input','data' => ['placeholder' => $this->getConfigs()->getPlaceholder(),'maxlength' => $this->getConfigs()->getSearchInputMaxLength()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('global-search-modal::search.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getConfigs()->getPlaceholder()),'maxlength' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->getConfigs()->getSearchInputMaxLength())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16)): ?>
<?php $attributes = $__attributesOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16; ?>
<?php unset($__attributesOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16)): ?>
<?php $component = $__componentOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16; ?>
<?php unset($__componentOriginal5b47f450d5bc9cd8e895cd9fc7ecfd16); ?>
<?php endif; ?>
</form><?php /**PATH /var/www/html/vendor/charrafimed/global-search-modal/resources/views/components/search/bar.blade.php ENDPATH**/ ?>